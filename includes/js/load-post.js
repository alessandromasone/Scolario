function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    const value = decodeURIComponent(results[2].replace(/\+/g, '%20'));
    return value.replace(/%20/g, ' ');
}

function load_data(url, page, query = '', category = '', view = '') {
    const urlParams = new URLSearchParams(window.location.search);
    (page !== 1) ? urlParams.set('page', page) : urlParams.delete('page');
    (query !== '') ? urlParams.set('query', query) : urlParams.delete('query');
    (category !== '') ? urlParams.set('category', category) : urlParams.delete('category');
    (view !== '') ? urlParams.set('view', view) : urlParams.delete('view');

    $.ajax({
        url: url,
        method: "POST",
        data: {
            page: page,
            query: query,
            category: category,
            view: view,
        },
        success: function (data) {
            $('#content-post').html(data);
        }
    });

    const paramsString = urlParams.toString();
    const newUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname}${paramsString ? `?${paramsString}` : ''}`;
    history.pushState(null, '', newUrl);

}


function dynamic_field(ulr, search_div, category_div, input_category, view_div, input_view) {

    $(document).on('click', '.page-link', function () {
        const query = $('#search-box').val();
        const page = $(this).data('page_number');
        const category = $(input_category + ':checked').val();
        const view = $(input_view + ':checked').val();
        load_data(ulr, page, query, category, view);
    });

    $(search_div).keyup(function () {
        const query = $('#search-box').val();
        const category = $(input_category + ':checked').val();
        const view = $(input_view + ':checked').val();
        load_data(ulr, 1, query, category, view);
    });


    let lastChecked_category = null;

    $(category_div).on('click', function () {
        const query = $(search_div).val();
        const page = 1;
        const view = $(input_view + ':checked').val();
        let category;
        if (lastChecked_category === this) {
            $(this).prop('checked', false);
            lastChecked_category = null;
            category = '';
        } else {
            lastChecked_category = this;
            category = $(input_category + ':checked').val();
        }
        load_data(ulr, page, query, category, view);
    });

    let lastChecked_view = null;

    $(view_div).on('click', function () {
        const query = $(search_div).val();
        const page = 1;
        const category = $(input_category + ':checked').val();
        let view;
        if (lastChecked_view === this) {
            $(this).prop('checked', false);
            lastChecked_view = null;
            view = '';
        } else {
            lastChecked_view = this;
            view = $(input_view + ':checked').val();
        }
        load_data(ulr, page, query, category, view);
    });


    const query = getParameterByName('query') || '';
    const page = getParameterByName('page') || 1;
    const category = getParameterByName('category') || '';
    const view = getParameterByName('view') || '';

    $(search_div).val(query);

    if (category) {
        $(`${input_category}[value="${category}"]`).prop('checked', true);
    }
    if (view) {
        $(`${input_view}[value="${view}"]`).prop('checked', true);
    }

    load_data(ulr, page, query, category, view);

}
