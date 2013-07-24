(function () {
    'use strict';

    function initEvents() {
        $('#search-user-button').click(function () {
            var search = document.getElementById('search-user-txt').value;
            window.location.href = Routing.generate('innova_directory_from_workspace', {
                'search': search,
            });
        });
    }

    initEvents();
})();
