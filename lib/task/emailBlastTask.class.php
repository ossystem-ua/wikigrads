<?php

class emailBlastTask extends sfBaseTask{
    
  public function configure()
  {
    $this->namespace = 'email';
    $this->name      = 'blast';
    
    
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'cli')
      ////   new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));
    
    
    
    
  }

  public function execute($arguments = array(), $options = array())
  {
      /*
        $contextInstance = sfContext::createInstance($this->configuration);
        $contextInstance->getConfiguration()->loadHelpers('Partial');      
        */
      $mailer  = $this->getMailer();
      
      
      $from = "hmonroy@endertech.com";
      $subject = "Testing";
      $body = "Testing body";
      $file ="lib/task/MathTAsUCLA.csv";

      $file_handle = fopen($file, "r");
    // echo getcwd();
     // var_dump($file_handle); exit;
     
      if($file_handle){
          while (!feof($file_handle)) {
            $line = fgets($file_handle);
            $recipient = explode(',', $line);
            echo "name: ".$recipient[0]." email: ".$recipient[1]."\n";
                // echo $line;
          }


        fclose($file_handle);      
      }
      //$mailer->composeAndSend("hmonroy@endertech.com", "hmonroy@endertech.com", $subject, $body);
    //echo 'Hello, World!';
  }   

    
}
?>
