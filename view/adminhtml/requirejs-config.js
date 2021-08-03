var config = {
    paths: {
        jqtree: 'Naxero_MenuManager/js/lib/jqtree/tree.jquery'
    },
    'shim': {
        'CKEditor_CKEditor4/js/ckeditor4/ckeditor': { 'exports': 'CKEDITOR' }
    },
    urlArgs: "bust=" + (new Date()).getTime()
};
