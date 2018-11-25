;(function() {

    var modalWindow = {};
    
    // Получаем код стилей модального окна для центрирования по горизонтали и вертикали
    function getCenterWindowStyles(width, height, measureType) {
        
        let styles;
        
        if ( height > 600 ) height = 600;
        if ( width > 800 ) width = 800;
        
        styles = "top: calc(50% - " + height/2 + measureType + "); " +
                 "left: calc(50% - " + width/2 + measureType + "); " +
                 "width: " + width + measureType + "; " +
                 "height: " + height + measureType + ";";

        return styles;
        
    }
    
    // Получаем код стилей положения крестика
    function getCrossStyles(width, height, measureType) {
        
        var styles;
        
        if ( height > 600 ) height = 600;
        if ( width > 800 ) width = 800;
        
        styles = "top: calc(50% - " + ( height / 2 + 12 ) + measureType + "); " +
                 "left: calc(50% + " + ( width / 2 - 12 ) + measureType + ");";

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
