import $ from 'jquery';
import mapbox from 'mapbox-gl';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
import '@toast-ui/jquery-editor';

export const b2b = (function () {
    function load_markdown_editor(link, options) {

        $('#' + link + '_editor').toastuiEditor($.extend(options, {
            initialEditType: 'markdown',
            previewStyle: 'vertical',
            initialValue: $('#' + link).val(),
            events: {
                change: function() {
                    $('#' + link).val($('#' + link + '_editor').toastuiEditor('getMarkdown'))
                }
            }
        }));
    }

    function load_mapbox_address_map(placeholder, lat, lng) {
        mapbox.accessToken = 'pk.eyJ1IjoibWFyb2xyb2xlbSIsImEiOiJja2Zxa3Nya2owc2p5MnlwYTdtcG04M3I5In0.Fcs6s8udeodqW0nFh7HXYQ';
        const map = new mapbox.Map({
            container: 'mapbox',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [lng, lat],
            language: 'pl-PL',
            zoom: 13
        });

        const marker = new mapbox.Marker()
            .setLngLat([lng, lat])
            .addTo(map);

        const geocoder = new MapboxGeocoder({
            accessToken: mapbox.accessToken,
            mapboxgl: mapbox,
            placeholder: placeholder
        });

        geocoder.on('result', function(data) {
            console.log(data);

            $('#latitude').val(data.result.center[1])
            $('#longitude').val(data.result.center[0]);
            $('#name').val(data.result.place_name);

            for (let i = 0; i < data.result.context.length; i++) {
                if (-1 !== data.result.context[i].id.indexOf('country')) {
                    const country_code = data.result.context[i].short_code;
                    $('#country_code option').removeAttr('selected')
                        .filter('[value=' + country_code.toUpperCase() + ']').attr('selected', true);
                    break;
                }
            }
        });

        document.getElementById('geocoder').appendChild(geocoder.onAdd(map));
    }

    return {
        load_markdown_editor: load_markdown_editor,
        load_mapbox_address_map: load_mapbox_address_map
    };
});

window.b2b = b2b;
