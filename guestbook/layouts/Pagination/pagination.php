<?php
    function getPagesArray($numOfRecords = 10, $currentPage = 1, $recordsPerPage = 10) {

        $result = [];
        $numOfPages = ceil($numOfRecords / $recordsPerPage);

        if($numOfPages <= 10) {
            for($i = 1; $i <= $numOfPages; $i++) $result[$i] = $i;
            return $result;

        } elseif($currentPage < 7) {

            for($i = 1; $i <= 8; $i++) $result[$i] = $i;
            $result[] = false;
            $result[$numOfPages] = $numOfPages;

        } elseif ($currentPage + 6 > $numOfPages) {
            $result[1] = 1;
            $result[] = false;
            for($i = $numOfPages - 7; $i <= $numOfPages; $i++) $result[$i] = $i;

        } else {
            $result[1] = 1;
            $result[] = false;

            for($i = $currentPage - 4; $i < $currentPage + 4; $i++) $result[$i] = $i;

            $result[] = false;
            $result[$numOfPages] = $numOfPages;
        }

        return $result;
    }

    function showPagination($pagesArray = [], $currentPage = 1) {
        $route = explode('?', $_SERVER['REQUEST_URI'])[0];
        unset($_GET['page']);
        unset($_GET['route']);
        foreach($_GET as $key => $value) $query.= "$key=$value&";

        foreach($pagesArray as $key => $value) {
            if(!$value) {
                echo "...";
                continue;
            }
            if($currentPage == $key) {
                echo "<a class='currentPage' href='".$route."?".$query."page=$value'>$key</a>";
            }else{
                 echo "<a href='".$route."?".$query."page=$value'>$key</a>";
            }
        }
    }
?>

<div class='pagination grid'>
    <div class='pages'>
        <?= showPagination($Data['pagination'], $Data['currentPage']); ?> 
    </div>
</div>