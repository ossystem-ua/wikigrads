<?php
class AutoPager {
    protected $baseLink = null;
    protected $pageNum = null;
    protected $recsPerPage = 5;
    protected $pageCount = null;
    protected $_isLastPage = null;

    public function __construct($options=array()) {
        $this->recsPerPage = Utils::getOptionValue($options, 'recs_per_page', $this->recsPerPage);
    }


/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                    //
// STATE                                                                             //
//                                                                                  //
/////////////////////////////////////////////////////////////////////////////////////
    public function isPageNumValid() {
        return ($this->pageNum <= $this->pageCount);
    }

    public function isLastPage() {
        if(!$this->pageCount) {
            return false;
            throw new Exception('cannot determine isLastPage without setting recCount');
        }
        return ($this->pageNum >= $this->pageCount);
    }


/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                    //
// SET                                                                               //
//                                                                                  //
/////////////////////////////////////////////////////////////////////////////////////
    public function setBaseLink($link) {
        $this->baseLink = $link;
    }

    public function setRecCount($recCount) {
        $this->recCount = $recCount;
        #echo "<div>recCount: $recCount</div>";
        #echo "<div>recsPerPage: $this->showPerPage</div>";
        if($recCount == 0) { // prevent divide by zero
            return 0;
        }
        $this->pageCount = ceil($recCount / $this->recsPerPage);
    }

    public function setPageNum($pageNum) {
        $this->pageNum = $pageNum;
    }

/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                    //
// GET                                                                               //
//                                                                                  //
/////////////////////////////////////////////////////////////////////////////////////
    public function getPageNum() {
        return $this->pageNum;
    }

    public function getPageNextLink() {
        $qsv = (strpos($this->baseLink, '?') !== false) ? '&page=' : '?page=';
        $qsv .= ($this->pageNum + 1);

        return url_for($this->baseLink . $qsv);
    }

    public function getOffset() {
        $factor = ($this->pageNum < 1) ? 0 : $this->pageNum - 1;
        $offset = $factor * $this->recsPerPage;
        #die($offset . ', '. $this->recsPerPage);
        return $offset;
    }

    public function getRecsPerPage() {
        return $this->recsPerPage;
    }

};
?>
