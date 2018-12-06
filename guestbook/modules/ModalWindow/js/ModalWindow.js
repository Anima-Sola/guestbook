;(function() {

    var modalWindow = {};
    
    // Получаем код стилей модального окна для центрирования по горизонтали и вертикали
    function getCenterWindowStyles(width, height, measureType) {
        
        var styles = '';

        var clientWidth = document.documentElement.clientWidth;
        var clientHeight = document.documentElement.clientHeight;

        if( measureType == '%' ) {

            if( width > 100 ) width = 100;
            if( height > 100) height = 100;
           
            widthInPx = clientWidth * width / 100;
            heightInPx = clientHeight * height / 100;

        } else {

            widthInPx = width;
            heightInPx = height;

            if ( width > clientWidth ) widthInPx = clientWidth;
            if ( height > clientHeight  ) heightInPx = clientHeight;

        }

        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        var top = scrollTop + clientHeight/2 - heightInPx/2;
        var left = clientWidth/2 - widthInPx/2;

        styles = "top: " + top + "px; " +
                 "left: " + left  + "px; " +
                 "width: " +  widthInPx + "px; " +
                 "height: " + heightInPx + "px; " +
                 "max-width: " + clientWidth + "px; " +
                 "max-height: " + clientHeight + "px;";

        return styles;
        
    }
    
    // Получаем код стилей положения крестика
    function getCrossStyles(width, height, measureType) {
        
        var styles = '';

        var clientWidth = document.documentElement.clientWidth;
        var clientHeight = document.documentElement.clientHeight;

        if( measureType == '%' ) {

            if( width > 100 ) width = 100;
            if( height > 100) height = 100;
           
            widthInPx = clientWidth * width / 100;
            heightInPx = clientHeight * height / 100;

        } else {

            widthInPx = width;
            heightInPx = height;

            if ( width > clientWidth ) widthInPx = clientWidth;
            if ( height > clientHeight  ) heightInPx = clientHeight;

        }

        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        var top = scrollTop + clientHeight/2 - heightInPx/2 - 12;
        var left = clientWidth/2 + widthInPx/2 - 12;

        styles = "top: " + top + "px; " +
                 "left: " + left  + "px; ";

        return styles;
        
    }
    
    // Получаем код события onclick закрытия модального окна
    function getCloseWindowEvent() {
        
        var events;
        
        events = "modalWindow.closeModalWindow(\"modalWindow\");";
        
        return events;        
        
    }

    // Закрытие модального окна
    function closeModalWindow() {
        
        var modalWindow = document.getElementById('modalWindow');
        modalWindow.remove();
        
    }
    
    //Открытие модального окна
    //id - элемента div модального окна в DOM
    //width - ширина модального окна
    //height - высота модального окна
    //measureType - единица измерения для width и height (px, em, % и т.д.)
    //content - содержимое окна (html)
    function showModalWindow(width, height, measureType, content) {

        var modalWindowDiv = document.createElement('div');
        modalWindowDiv.setAttribute('id', 'modalWindow');
        modalWindowDiv.setAttribute('class', 'modal-window');

        var body = document.body;
        body.insertBefore(modalWindowDiv, body.firstChild);
        
        var modalWindow = document.getElementById('modalWindow');
 
        html = "<div class='modal-window__overlay' onclick='" + getCloseWindowEvent() + "'></div>" +
                   "<div class='modal-window__content' style='" + getCenterWindowStyles(width, height, measureType) + "'>" +
                        "<div class='modal-window__content-wrapper'>" + 
                            "<div>" + content + "</div>" +
                        "</div>" +
                    "</div>" +
               "<div class='modal-window__cross' onclick='" + getCloseWindowEvent() + "' style='" + getCrossStyles(width, height, measureType) + "'>X</div>";
        modalWindow.innerHTML = html;
        
    }

    modalWindow.showModalWindow = showModalWindow;
    modalWindow.closeModalWindow = closeModalWindow;
    
    window.modalWindow = modalWindow;

})();
