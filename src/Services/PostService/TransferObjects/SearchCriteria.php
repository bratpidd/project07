<?php

namespace App\Services\PostService\TransferObjects;

class SearchCriteria
{

    public $sortOrder;
    public $filterByTag;
    public $recordsOnPage;
    public $pageNumber;

    public function __construct() {
        $this->sortOrder = "ASC";
        $this->filterByTag = "";
        $this->recordsOnPage = 10;
        $this->pageNumber = 1;
    }

}