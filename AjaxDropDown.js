/*!
 * AjaxDropDown v1.1.1
 * Paweł Bizley Brzozowski
 * https://github.com/bizley-code/Yii-AjaxDropDown
 * http://www.yiiframework.com/extension/ajaxdropdown
 */
(function ($) {
    $.fn.ajaxDropDown = function (options) {
        var set = $.extend(true, {
            addc: '',
            ercl: '',
            erst: '',
            hecl: '',
            hest: '',
            locl: '',
            lost: '',
            mabe: '',
            maen: '',
            minq: 0,
            name: 'ajaxDropDown',
            nebe: '',
            necl: '',
            neen: '',
            nest: '',
            nrcl: '',
            nrst: '',
            pabe: '',
            paen: '',
            prbe: '',
            prcl: '',
            pren: '',
            prst: '',
            prba: '',
            recl: '',
            rest: '',
            rmcl: '',
            rmla: '',
            rmst: '',
            rscl: '',
            rsst: '',
            smod: false,
            swcl: '',
            swst: '',
            url: '',
            loca: {
                allr: 'All records',
                rcon: 'Records containing',
                mcha: 'Type at least {NUM} character(s) to filter the results...',
                erro: 'Error',
                prev: 'prev',
                next: 'next',
                nrec: 'No matching records found'
            }
        }, options);
        var ul = this.find('ul.ajaxDropDownMenu');
        var prba = '<li class="ajaxDropDownLoading';
        if (set.locl !== '') prba += ' ' + set.locl;
        prba += '"';
        if (set.lost !== '') prba += ' style="' + set.lost + '"';
        prba += '>' + set.prba + '</li>';
        var headerStart = '<li class="dropdown-header';
        if (set.hecl !== '') headerStart += ' ' + set.hecl;
        headerStart += '"';
        if (set.hest !== '') headerStart += ' style="' + set.hest + '"';
        headerStart += '>';
        var headerMinimumCharacters = set.loca.mcha.replace(/{NUM}/g, set.minq);
        var erro = '<li class="dropdown-header';
        if (set.ercl !== '') erro += ' ' + set.ercl;
        erro += '"';
        if (set.erst !== '') erro += ' style="' + set.erst + '"';
        erro += '>' + set.loca.erro + '</li>';
        var nrec = '<li class="dropdown-header';
        if (set.nrcl !== '') nrec += ' ' + set.nrcl;
        nrec += '"';
        if (set.nrst !== '') nrec += ' style="' + set.nrst + '"';
        nrec += '>' + set.loca.nrec + '</li>';
        this.on('show.bs.dropdown', function(){
            if (ul.find('li.ajaxDropDownPages').length === 0) {
                var page = $(this).find('button.ajaxDropDownToggle').data('page');
                page = page * 1;
                var search = false;
                var header = headerStart + set.pabe + '<span class="ajaxDropDownPageNumber">' + page + '</span>/<span class="ajaxDropDownTotalPages">1</span>';
                header += set.paen + set.loca.allr + '</li><li class="divider"></li>' + prba;
                var query = $(this).find('input[type=text]').val();
                if (set.minq > 0) {
                    if (query.length >= set.minq) {
                        header = headerStart + set.pabe + '<span class="ajaxDropDownPageNumber">' + page + '</span>/<span class="ajaxDropDownTotalPages">1</span>';
                        header += set.paen + set.loca.rcon + ' <strong>' + query;
                        header += '</strong></li><li class="divider"></li>' + prba;
                        search = true;
                    }
                    else header = headerStart + headerMinimumCharacters + '</li>';
                }
                else search = true;
                ul.html(header);
                if (search) {
                    $.post(set.url, {query:query, page:page}).
                        fail(function(){ul.append(erro);}).
                        done(function(data){
                            var results = $.parseJSON(data);
                            if (results.total === undefined) results.total = 1;
                            if (results.page === undefined) results.page = 1;
                            if (results.data.length) {
                                ul.find('span.ajaxDropDownTotalPages').text(results.total);
                                for (i in results.data) {
                                    var result = '<li class="ajaxDropDownPages ajaxDropDownPage' + results.page + ' ajaxDropDownRecord'+ results.data[i].id;
                                    if (set.recl !== '') result += ' ' + set.recl;
                                    if (ul.parent().parent().parent().find('li.ajaxDropDownSelected' + results.data[i].id).length) result += ' active';
                                    result += '"';
                                    if (set.rest !== '') result += ' style="' + set.rest + '"';
                                    result += '><a href="#" class="ajaxDropDownResult" data-id="'+ results.data[i].id +'">';
                                    if (results.data[i].mark) result += set.mabe;
                                    result += results.data[i].value;
                                    if (results.data[i].mark) result += set.maen;
                                    result += '</a></li>';
                                    ul.append(result);
                                }
                                if (results.total > 1) {
                                    var pages = '<li class="divider ajaxDropDownInfo"></li><li class="ajaxDropDownInfo';
                                    if (set.swcl !== '') pages += ' ' + set.swcl;
                                    pages += '"';
                                    if (set.swst !== '') pages += ' style="' + set.swst + '"';
                                    pages += '><a href="#" class="ajaxDropDownPrev';
                                    if (set.prcl !== '') pages += ' ' + set.prcl;
                                    if (results.page === 1) {
                                        pages += ' disabled';
                                    }
                                    pages += '"';
                                    if (set.prst !== '') pages += ' style="' + set.prst + '"';
                                    pages += '>' + set.prbe + set.loca.prev + set.pren + '</a><a href="#" class="ajaxDropDownNext';
                                    if (set.necl !== '') pages += ' ' + set.necl;
                                    if (results.page === results.total) {
                                       pages += ' disabled';
                                    }
                                    pages += '"';
                                    if (set.nest !== '') pages += ' style="' + set.nest + '"';
                                    pages += '>' + set.nebe + set.loca.next + set.neen + '</a></li>';
                                    ul.append(pages);
                                }
                            }
                            else ul.append(nrec);
                        }).
                        always(function(){$('li.ajaxDropDownLoading').remove();});
                }
            }
        });
        this.on('click', 'a.ajaxDropDownNext', function(e){
            e.preventDefault();
            e.stopPropagation();
            ul.find('a.ajaxDropDownPrev').removeClass('disabled');
            ul.find('a.ajaxDropDownNext').addClass('disabled');
            var page = ul.parent().find('button.ajaxDropDownToggle').data('page');
            page = page * 1 + 1;
            if (ul.find('li.ajaxDropDownPage' + page).length) {
                ul.find('li.ajaxDropDownPages').addClass('hidden');
                ul.find('li.ajaxDropDownPage' + page).removeClass('hidden');
                ul.find('a.ajaxDropDownNext').removeClass('disabled');
            }
            else {
                var query = ul.parent().parent().find('input[type=text]').val();
                $.post(set.url, {query:query, page:page}).
                    fail(function(){ul.append(erro);}).
                    done(function(data){
                        var results = $.parseJSON(data);
                        if (results.data.length) {
                            ul.find('.ajaxDropDownPages').addClass('hidden');
                            if (results.total === undefined) results.total = 1;
                            if (results.page === undefined) results.page = 1;
                            for (i in results.data) {
                                var result = '<li class="ajaxDropDownPages ajaxDropDownPage' + results.page + ' ajaxDropDownRecord'+ results.data[i].id;
                                if (set.recl !== '') result += ' ' + set.recl;
                                if (ul.parent().parent().parent().find('li.ajaxDropDownSelected' + results.data[i].id).length) result += ' active';
                                result += '"';
                                if (set.rest !== '') result += ' style="' + set.rest + '"';
                                result += '><a href="#" class="ajaxDropDownResult" data-id="'+ results.data[i].id +'">';
                                if (results.data[i].mark) result += set.mabe;
                                result += results.data[i].value;
                                if (results.data[i].mark) result += set.maen;
                                result += '</a></li>';
                                ul.find('.divider.ajaxDropDownInfo').before(result);
                            }
                            if (results.page < results.total) ul.find('a.ajaxDropDownNext').removeClass('disabled');
                            else page = results.total;
                        }
                        else ul.append(nrec);
                    });
            }
            ul.parent().find('button.ajaxDropDownToggle').data('page', page);
            ul.find('span.ajaxDropDownPageNumber').text(page);
        });
        this.on('click', 'a.ajaxDropDownPrev', function(e){
            e.preventDefault();
            e.stopPropagation();
            ul.find('a.ajaxDropDownNext').removeClass('disabled');
            ul.find('a.ajaxDropDownPrev').addClass('disabled');
            var page = ul.parent().find('button.ajaxDropDownToggle').data('page');
            page = page * 1 - 1;
            if (page < 1) page = 1;
            ul.find('li.ajaxDropDownPages').addClass('hidden');
            ul.find('li.ajaxDropDownPage' + page).removeClass('hidden');
            if (page > 1) ul.find('a.ajaxDropDownPrev').removeClass('disabled');
            ul.parent().find('button.ajaxDropDownToggle').data('page', page);
            ul.find('span.ajaxDropDownPageNumber').text(page);
        });
        this.on('keyup', 'input[type=text]', function(){
            $(this).parent().find('button.ajaxDropDownToggle').data('page', 1);
            $(this).parent().find('ul.ajaxDropDownMenu').find('li.ajaxDropDownPages').remove();
        });
        this.on('click', 'a.ajaxDropDownResult', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var label = $(this).html();
            var results = $(this).parent().parent().parent().parent().parent().find('ul.ajaxDropDownResults');
            var arrayMode = '[]';
            if (set.smod) {
                results.html('');
                $(this).parent().parent().find('li.ajaxDropDownPages').removeClass('active');
                arrayMode = '';
            }
            if ($(this).parent().hasClass('active')) {
                $(this).parent().removeClass('active');
                results.find('li.ajaxDropDownSelected' + id).remove();
            }
            else {
                $(this).parent().addClass('active');
                if (set.smod) arrayMode = '';
                var selected = '<li class="ajaxDropDownSelected' + id;
                if (set.rscl !== '') selected += ' ' + set.rscl;
                selected += '"';
                if (set.rsst !== '') selected += ' style="' + set.rsst + '"';
                selected += '><a href="#" class="ajaxDropDownRemove';
                if (set.rmcl !== '') selected += ' ' + set.rmcl;
                selected += '"';
                if (set.rmst !== '') selected += ' style="' + set.rmst + '"';
                selected += ' data-id="' + id + '">' + set.rmla + '</a>' + set.addc + label + '<input type="hidden" name="' + set.name + arrayMode + '" value="' + id + '" /></li>';

                results.append(selected);
            }
        });
        this.on('click', 'a.ajaxDropDownRemove', function(e){
            e.preventDefault();
            $(this).parent().parent().parent().find('li.ajaxDropDownRecord' + $(this).data('id')).removeClass('active');
            $(this).parent().remove();
        });
        return this;
    };
}(jQuery));
