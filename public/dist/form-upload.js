(function ($) {
    var lists = [];
    var querying = false;
    var dropdown = $(".search-dropdown");
    var searchInput = $("#searchInput");
    var searchButton = $("#searchButton");
    var keywords = '';

    function queryData() {
        if (querying) {
            return false;
        }
        $.ajax({
            type: 'GET',
            url: '/rental/units',
            data: {q: keywords},
            beforeSend: function () {
                querying = true;
                //dropdown.html('<div class="dropdown-item-text loading" role="status"></div>').show();
            },
            success: function (res) {
                //console.log(res);
                lists = res.result.items;
                filterData();
            },
            complete: function (xhr) {
                //console.log(xhr);
                querying = false;
            }
        });
    }

    function filterData() {
        var results = lists;
        var arr = keywords.split(/\s/ig);
        for (var i = 0; i < arr.length; i++) {
            if (arr[i]) {
                results = results.filter(function (d) {
                    return d.formatted_address.toLowerCase().indexOf(arr[i].toLowerCase()) !== -1;
                });
            }
        }

        if (results.length > 0) {
            dropdown.empty();
            $(results).each(function (i, d) {
                var str = d.formatted_address;
                $('<a/>').addClass('dropdown-item')
                    .html(str)
                    .on('click', function () {
                        dropdown.hide();
                        searchInput.val(str);
                    })
                    .appendTo('.search-dropdown');
            });
        } else {
            dropdown.html('<div class="text-center text-muted">no results</div>');
        }

        dropdown.show();
    }

    // searchInput.on('keyup', function () {
    //     keywords = $.trim($(this).val());
    //     if (keywords.length > 0) {
    //         if (lists.length > 0) {
    //             filterData();
    //         } else {
    //             dropdown.html('<div class="dropdown-item-text loading" role="status"></div>').show();
    //             queryData();
    //         }
    //     } else {
    //         dropdown.empty().hide();
    //     }
    // });

    var offset = 0;
    var limit = 50;
    var formUpload = $("#formUpload");
    var searchDropdown = $("#searchDropdown");
    var searchLoading = $("#searchLoading");
    var searchResults = $("#searchResults");
    var searchResultsUl = $("#searchResultsUl");
    var loadMore = $("#loadmore");
    var btnSearch = $("#btnSearch");
    var searchUnits = function () {
        //console.log(formobj);
        $.ajax({
            type: 'GET',
            url: formobj.api,
            data: {q: searchInput.val(), offset: offset, limit: limit},
            beforeSend: function () {
                searchDropdown.show();
                searchLoading.css('display', 'flex');
            },
            success: function (res) {
                //console.log(res);
                searchLoading.hide();
                searchResults.show();
                $(res.result.items).each(function (index, o) {
                    var li = $('<li/>').html(o.formatted_address).on('click', function () {
                        $("[name=UnitId]").val(o.Id);
                        searchInput.val(o.formatted_address);
                        searchDropdown.hide();
                    });
                    searchResultsUl.append(li);
                });

                if (res.result.items.length === limit) {
                    loadMore.show();
                } else {
                    loadMore.hide();
                }
            },
            complete: function (xhr) {
                //console.log(xhr);
                querying = false;
            }
        });
    }
    btnSearch.on('click', function () {
        if (searchInput.val()) {
            offset = 0;
            searchUnits();
            searchResultsUl.empty();
        }
    });

    loadMore.on('click', function () {
        offset += limit;
        searchUnits();
    });

    var btnUpload = $("#btnUpload");
    btnUpload.on('click', function () {
        if (formUpload.find('[name=UnitId]').val() === '0') {
            toast.show('Please Select Association');
            return false;
        }

        if (!$("#inputFile").val()) {
            toast.show('Please Select File');
            return false;
        }

        btnUpload.attr('disabled', true).html('Sending...');
        formUpload.submit();
    });

    $("#inputFile").on('change', function (e) {
        if (e.target.files.length > 0) {
            $(e.target.files).each(function (i,file) {
                var fielListItem = $('<div/>')
                    .addClass('filelist-item')
                    .html('<div class="filename">'+file.name+'</div><i class="bi bi-trash3"></i>');
                $("#fileList").append(fielListItem);
            });
        }
        return true;
    });

    $("#btnSelectFile").on('click', function () {
        $("#inputFile").trigger('click');
    });
})(jQuery);