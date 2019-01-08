<?php
    namespace guestbook;

    class Pagination {

        //Функция возвращает массив чисел, в зависимости от количества записей, текущей страницы 
        //и необходимого количества записей на страницу для навигации
        protected function getPagesArray($numOfRecords, $currentPage, $recordsPerPage) {

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

        //Функция выводит ссылки для выбора станицы
        protected function showPagination($pagesArray = [], $currentPage) {
            echo "<div class='pagination'>
                  <div class='pages'>";

            //Получаем маршрут без GET параметров
            $route = explode('?', $_SERVER['REQUEST_URI'])[0];

            //Удаляем из массива GET параметр 'page'. Остальные GET параметры оставляем и формируем строку для вставки 
            //в URLы. GET параметров кроме 'page' может быть сколько угодно, их нельзя терять.
            unset($_GET['page']);
            foreach($_GET as $key => $value) $query .= "$key=$value&";
    
            //Выводим ссылки с числами, полученными от function getPagesArray.
            //URL - получается из маршрута, GET-параметра 'page' и остальных GET-параметров
            //Текущая страница выделяется классом currentPage
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
            
            echo "</div>
                  </div>";

        }

        function __construct($numOfRecords = 25, $currentPage = 1, $recordsPerPage = 25) {
            
            $pagesArray = $this->getPagesArray($numOfRecords, $currentPage, $recordsPerPage);

            $this->showPagination($pagesArray, $currentPage);

        }

    }
