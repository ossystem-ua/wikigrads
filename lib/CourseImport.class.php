<?php

/**
 * CourseImport
 * 
 * Imports School Course CSV file into..
 * 
 * - Department
 * - Course
 * - AcademicTermCourse
 * 
 * File format expectations:
 * 
 * - Row 1 - Headers
 * - Row 2+ - Data
 * - Columns (School - Term [Not used], Department, Course, Instructor)
 * 
 * Valid example data:
 * 
 * null, Accounting (ACCT), 501 - Accounting, John Smith
 * null, null, 402 lbc - Long Beach Medical, "John Smith, Jane Doe"
 * 
 * The first example row has the full information.
 * The second row is missing the department.  In this case it will assume that ACCT is the current department.
 * Departments must have an alias within ().
 * Course codes can have letters, numbers, and spaces.
 * Courses must have a course code dash course name.
 * Instructors are just a string of text.
 * 
 * @author Carey Hinoki
 * @since 2011-07-27
 */
class CourseImport
{
    # csv read size
    const READ_SIZE = 255;
    
    protected $row_index = 0;
    
    # tmp file name + default form parameters
    protected $file = null;
    protected $school_id = null;
    protected $academic_term_id = null;
    
    
    # file handle + info
    protected $handle = null;
    protected $header = null;
    
    # import row counts
    protected $import_department = 0;
    protected $import_course = 0;
    protected $import_row = 0;
    
    # import script execution time
    protected $duration = null;

    protected $errors = array();

    public function __construct($file, $school_id, $academic_term_id)
    {
        # ensure file exists
        if (file_exists($file)) {
        	$this->file = $file;
        } else {
            throw new Exception('Unable to read '.$file);
        }
        
        $this->school_id = $school_id;
        $this->academic_term_id = $academic_term_id;
    }
    
    private function checkSymbol($char, &$i) {
        switch (ord($char)) {
            case 13: { return ";"; }break;
            case 201: { return " "; }break;
        }
        return $char;
    }
    
    /**
     * Import
     * 
     * Import process of the file - see above for details.
     *
     */
    public function import()
    {
        $start = microtime(true);
        
        $fp = fopen ($this->file, 'r');
        if (!$fp) return false;
        $buffer = '';
        $i = 0;
        while (!feof($fp)) {
            $char = fgetc($fp);
            $buffer .= $this->checkSymbol($char, $i);
        }
        fclose($fp);
       
        $arr_all_text = explode(';', $buffer); 
        
        $str_B = '';
        $cd = 0;
        foreach ($arr_all_text as $row) {
            if ($cd == 0) { $cd++; continue; }
            
            $row = trim($row);
            if (strlen($row) > 0) {
                
                $arr_row = array();
                $bAccess = true;
                $str = "";
                for ($i = 0; $i <= strlen($row); $i++) {
                    if($i < strlen($row)) {
                        if ($row[$i] == ",") {
                            if ($bAccess == true) { 
                                $str = str_replace("\"", "", $str);
                                $str = str_replace("\'", "", $str);
                                $arr_row[] = $str; 
                                $str = "";
                            }
                        } else {
                            if ($row[$i] == '"' || $row[$i] == "'") {
                                if ($bAccess == true) { $bAccess = false; }
                                else { $bAccess = true; }                                   
                            }
                            $str .= $row[$i];
                        }
                    } else {
                        if ($bAccess == true) { 
                            $str = str_replace("\"", "", $str);
                            $str = str_replace("\'", "", $str);
                            $arr_row[] = $str; 
                            $str = "";                         
                        }
                        break;
                    }
                }
                
                if (strlen($arr_row[1]) <= 0) { $arr_row[1] = $str_B; }
                else { $str_B = $arr_row[1]; }
                //
                //echo "<br/>";print_r($arr_row);
                //if (strlen($arr_row[4]) > 0) echo "<br/>".$arr_row[4];
                /**/
                ++$this->row_index;            
                if ($parsed_department = $this->parseDepartment($arr_row[1])) {
                    list($department_name, $department_alias) = $parsed_department;
                
                    # insert department
                    if (!$department = $this->getDepartment($this->school_id, $department_name)) {
                        $this->insertDepartment($this->school_id, $department_name, $department_alias);
                        $department = $this->getDepartment($this->school_id, $department_name);            	    
                        $this->import_department++;
                    }
                
                    # parse the course information
                    $parsed_course = false;
                    if (isset($arr_row[2])) {
                        $parsed_course = $this->parseCourse($arr_row[2]);
                    }
                    if($parsed_course){
                        list($course_code, $course_name) = $parsed_course;
                    
                        # insert course - use current department
                        if (!$course = $this->getCourse($department['id'], $course_code)) {
                            $instructor = null;
            	    
                            # only set the instructor if value exists
                            if (isset($arr_row[3]) && $arr_row[3]) {
                                $instructor = $arr_row[3];
                            }
                        
                            $this->insertCourse($arr_row[4], $department['id'], $course_name, $course_code);            	    
                            $course = $this->getCourse($department['id'], $course_code);            	    
                            $this->import_course++;
                        }
                        
                        if (!$academic_term_course = $this->getAcademicTermCourse($this->academic_term_id, $course['id'])) {
                            $this->insertAcademicTermCourse($this->academic_term_id, $course['id']);                	
                            $this->import_row++;
                        }
                    } else {
                        $this->errors[] = 'Missing Course in file at line: '.$this->row_index;
                    }
                } else {
                    $this->errors[] = 'Missing Department in file at line: '.$this->row_index;
                }/**/
            }
        }
        
        $end = microtime(true);        
        $this->duration = number_format($end - $start, 4);        
    }
    
    #####
    # Fetch
    ###
    
    protected function getDepartment($school_id, $name)
    {
    	$name = addslashes($name);
    	
        $sql = "
    	   SELECT d.*
    	   FROM department d
    	   WHERE d.school_id = {$school_id}
    	   AND d.name = '{$name}';";
        
        $con = Doctrine_Manager::getInstance()->getCurrentConnection();
	    
        $pdo = $con->execute($sql);
	    $pdo->setFetchMode(Doctrine_Core::FETCH_ASSOC);
	    
	    return $pdo->fetch();
    }
    
    protected function insertDepartment($school_id, $name, $alias) {
        $sql = "
            INSERT INTO department (school_id, name, alias, created_at, updated_at)
            VALUES ({$school_id}, '".addslashes($name)."', '".addslashes($alias)."', NOW(), NOW())";
        
        $con = Doctrine_Manager::getInstance()->getCurrentConnection();
	$result = $con->execute($sql);
    }
    
    protected function getCourse($department_id, $code)
    {
        $sql = "
            SELECT c.*
            FROM course c
            WHERE c.department_id = {$department_id}
            AND c.code = '{$code}'";
        
        $con = Doctrine_Manager::getInstance()->getCurrentConnection();
        
        $pdo = $con->execute($sql);
	    $pdo->setFetchMode(Doctrine_Core::FETCH_ASSOC);
	    
	    return $pdo->fetch();
    }
    
    protected function insertCourse($category, $department_id, $name, $code, $instructor = null)
    {
        if ($instructor == null) {
        	$instructor = 'NULL';
        } else {
            $instructor = "'".addslashes($instructor)."'";
        }
       
        if ($category == null) { $category = 'NULL'; }
        else { $category = addslashes($category); }
        
        $sql = "
            INSERT INTO course (department_id, name, code, instructor, created_at, updated_at, category)
            VALUES ({$department_id}, '".addslashes($name)."', '".addslashes($code)."', {$instructor}, NOW(), NOW(), '".$category."')";
        
        $con = Doctrine_Manager::getInstance()->getCurrentConnection();
        $result = $con->execute($sql);
    }
    
    protected function getAcademicTermCourse($academic_term_id, $course_id)
    {
        $sql = "
            SELECT atc.*
            FROM academic_term_course atc
            WHERE atc.academic_term_id = {$academic_term_id}
            AND atc.course_id = {$course_id}";
        
        $con = Doctrine_Manager::getInstance()->getCurrentConnection();
        
        $pdo = $con->execute($sql);
	    $pdo->setFetchMode(Doctrine_Core::FETCH_ASSOC);
	    
	    return $pdo->fetch();
    }
    
    protected function insertAcademicTermCourse($academic_term_id, $course_id) {    
        $sql = "
            INSERT INTO academic_term_course (academic_term_id, course_id, created_at, updated_at)
            VALUES ({$academic_term_id}, {$course_id}, NOW(), NOW())";
        
        $con = Doctrine_Manager::getInstance()->getCurrentConnection();
	$result = $con->execute($sql);
    }

    public function getErrors(){
        return count($this->errors) > 0 ? $this->errors : false;
    }

    protected function getFileHandle()
    {
        if ($this->handle == null) {
        	$this->handle = fopen($this->file, 'rb');
        }
        
        return $this->handle;
    }
    
    public function getFileHeader()
    {
        if ($this->header == null) {
        	$handle = $this->getFileHandle();
        
            fseek($handle, 0);
            
            $this->header = fgetcsv($handle, self::READ_SIZE);
        }
        
        return $this->header;
    }


    public function countImportDepartment()
    {
        return $this->import_department;
    }
    
    public function countImportCourse()
    {
        return $this->import_course;
    }
    
    public function countImportRow()
    {
        return $this->import_row;
    }
    
    public function countDuration()
    {
        return $this->duration;
    }
    
    #####
    # Parse
    ###
    
    /**
     * Parse Course
     * 
     * <Course Code> - <Course Name>
     * 
     * Must match format: Code - Name
     *
     * @param unknown_type $course
     * @return unknown
     */
    private function parseCourse($course)
    {
        preg_match('#^([\w\s]+)\s*-\s*(.*?)$#', $course, $matches);

        if (!(isset($matches[1]) && $matches[1] && isset($matches[2]) && $matches[2])) {

        	$this->errors[] = "Unable to parse course '$course' on line: ".$this->row_index. '. Course was not added.';
        	return false;

        	//throw new Exception('Unable to parse course '.$course.' on line: '.$this->row_index);
        }


        return array(
            $matches[1],
            $matches[2],
        );
    }
    
    /**
     * Parse Department
     * 
     * <Department Name> (<Department Alias>)
     * 
     * Must match format: Name (Alias)
     *
     * @param unknown_type $department
     * @return unknown
     */
    private function parseDepartment($department)
    {
    	$alias = null;
    	$department = trim($department);
    	
        if (preg_match('#\(.*?\)$#', $department, $matches)) {
        	$alias = current($matches);
        }
        
        $department = trim(str_replace($alias, '', $department));
        $alias = trim(preg_replace('#[()]#', '', $alias));
        
        if (!($department && $alias)) {
           // 'Missing Department in file at line: '.$this->row_index. '. Update the file and try again.'
            $this->errors[] = "Unable to parse department '$department' in file at line: ".$this->row_index.'. Update the file and try again.';
            return false;
        	//throw new Exception('Unable to parse department '.$department);
        }
        
        return array(
            $department,
            $alias,
        );
    }
}