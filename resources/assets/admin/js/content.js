import $ from 'jquery';
import 'bootstrap-tagsinput';
import './vendor/jquery.nested';

export const content = (function () {
    function load_sort_categories(link, url, token) {
        const element = $('#' + link);

        element.nestable({});

        element.on('change', function() {
            $.post(url, {
                '_token': token,
                'data': element.nestable('serialize')
            })
        });
    }

    function load_entry_categories(link, url, categories, token) {
        const element = $('#' + link);

        element.tagsinput({
            allowDuplicates: true,
            tagClass: function(item) {
                return 'badge badge-secondary'
            },
            typeahead: {
                name: 'categories_id',
                displayKey: 'text',
                source: function(query) {
                    return $.post(url, {
                        '_token': token,
                        'q': query
                    }).done(function(data) {
                        return data;
                    });
                }
            },
            itemValue: 'value',
            itemText: 'text',
        });

        element.on('itemAdded', function(event) {
            setTimeout(function(){
                $(">input[type=text]",".bootstrap-tagsinput").val("");
            }, 1);
        });

        element.on('onTagExists', function(item, $tag) {
            $tag.hide.fadeIn();
        })

        const collection = $.parseJSON(categories);

        for (let step = 0; step < collection.length; step++) {
            element.tagsinput('add', collection[step]);
        }
    }

    return {
        load_sort_categories: load_sort_categories,
        load_entry_categories: load_entry_categories
    };
});

window.content = content;
