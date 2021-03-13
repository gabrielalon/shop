import $ from "jquery";

export const account = (function () {
    function load_avatar(link, locale, defaultPreviewContent) {
        $("#" + link).fileinput({
            language: locale,
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: defaultPreviewContent,
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    }

    return {
        load_avatar: load_avatar
    };
});

window.account = account;
