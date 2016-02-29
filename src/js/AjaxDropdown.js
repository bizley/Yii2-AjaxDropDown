/*!
 * AjaxDropDown v1.3.2
 * Pawel Bizley Brzozowski
 * https://github.com/bizley-code/Yii2-AjaxDropDown
 * http://www.yiiframework.com/extension/yii2-ajaxdropdown
 */
(function ($) {
    $.fn.ajaxDropDown = function (options) {
        var set = $.extend(true, {
            addc: '', dely: 300, ercl: '', erst: '', hecl: '', hest: '', 
            jsev: true, keyt: true, locl: '', lost: '', mabe: '', maen: '', 
            minq: 0, name: 'ajaxDropDown', nebe: '', necl: '', neen: '', 
            nest: '', nrcl: '', nrst: '', onrm: '', onsl: '', pabe: '', 
            paen: '', prbe: '', prcl: '', pren: '', prst: '', prba: '', 
            recl: '', rest: '', rmcl: '', rmla: '', rmst: '', rscl: '', 
            rsst: '', smbt: false, smod: false, swcl: '', swst: '', url: '', 
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
        var accl = 'active';
        var ajRec = ' ajaxDropDownRecord';
        var ali = '</a></li>';
        var aNext = 'a.ajaxDropDownNext';
        var aPrev = 'a.ajaxDropDownPrev';
        var buttSR = 'button.ajaxDropDownSingleRemove';
        var buttTogg = 'button.ajaxDropDownToggle';
        var dataId = '><a href="#" class="ajaxDropDownResult" data-id="';
        var dicl = 'disabled';
        var hicl = 'hidden';
        var inpTxt = 'input[type=text]';
        var li = '</li>';
        var lih = '<li class="dropdown-header';
        var liPage = 'li.ajaxDropDownPage';
        var liPages = 'li.ajaxDropDownPages';
        var liPagesAll = '<li class="ajaxDropDownPages ajaxDropDownPage';
        var liSel = 'li.ajaxDropDownSelected';
        var spNum = 'span.ajaxDropDownPageNumber';
        var st = ' style="';
        var ulMenu = 'ul.ajaxDropDownMenu';
        var timeOut = null;
        var selection = [];
        var onRemove = new Function('id', 'selection', set.onrm);
        var onSelect = new Function('id', 'label', 'selection', set.onsl);
        var rearrange = function(id) {
            var rearrSelection = [];
            for (var i in selection) {
                if (selection[i].id != id) {
                    rearrSelection.push(selection[i]);
                }
            }
            selection = rearrSelection;
        };
        var isin = function(id) {
            for (var i in selection) {
                if (selection[i].id == id) {
                    return true;
                }
            }
            return false;
        };
        var res = this.find('ul.ajaxDropDownResults');
        var rem = this.find(buttSR);
        var ul = this.find(ulMenu);
        var tx = this.find(inpTxt);
        var bt = this.find(buttTogg);
        var btns = this.find('div.ajaxDropDownButtons');
        var prba = '<li class="ajaxDropDownLoading';
        if (set.locl !== '') prba += ' ' + set.locl;
        prba += '"';
        if (set.lost !== '') prba += st + set.lost + '"';
        prba += '>' + set.prba + li;
        var headerStart = lih;
        if (set.hecl !== '') headerStart += ' ' + set.hecl;
        headerStart += '"';
        if (set.hest !== '') headerStart += st + set.hest + '"';
        headerStart += '>';
        var headerMinimumCharacters = set.loca.mcha.replace(/{NUM}/g, set.minq);
        var erro = lih;
        if (set.ercl !== '') erro += ' ' + set.ercl;
        erro += '"';
        if (set.erst !== '') erro += st + set.erst + '"';
        erro += '>' + set.loca.erro + li;
        var nrec = lih;
        if (set.nrcl !== '') nrec += ' ' + set.nrcl;
        nrec += '"';
        if (set.nrst !== '') nrec += st + set.nrst + '"';
        nrec += '>' + set.loca.nrec + li;
        var loadData = function(){
            if (ul.find(liPages).length === 0) {
                var page = bt.data('page');
                page = page * 1;
                var search = false;
                var hst = headerStart + set.pabe + '<span class="ajaxDropDownPageNumber">' + page + '</span>/<span class="ajaxDropDownTotalPages">1</span>';
                var header = hst;
                header += set.paen + set.loca.allr + '</li><li class="divider"></li>' + prba;
                var query = tx.val();
                if (query.length > 0) {
                    if (query.length >= set.minq) {
                        header = hst;
                        header += set.paen + set.loca.rcon + ' <strong>' + query;
                        header += '</strong></li><li class="divider"></li>' + prba;
                        search = true;
                    }
                    else header = headerStart + headerMinimumCharacters + li;
                }
                else search = true;
                ul.html(header);
                if (search) {
                    $.post(set.url, {query:query, page:page}).
                        fail(function(){
                            ul.append(erro);
                            console.log('jQuery post failed');
                        }).
                        done(function(data){
                            var results = $.parseJSON(data);
                            if (results.total === undefined) results.total = 1;
                            if (results.page === undefined) results.page = 1;
                            if (results.data === undefined) {
                                ul.append(erro);
                                console.log('No data element in results object', data);
                            }
                            else {
                                if (results.data.length) {
                                    ul.find('span.ajaxDropDownTotalPages').text(results.total);
                                    for (var i in results.data) {
                                        var result = liPagesAll + results.page + ajRec + results.data[i].id;
                                        if (set.recl !== '') result += ' ' + set.recl;
                                        if (ul.parent().parent().parent().find(liSel + results.data[i].id).length) result += ' ' + accl;
                                        result += '"';
                                        if (set.rest !== '') result += st + set.rest + '"';
                                        result += dataId + results.data[i].id +'">';
                                        if (results.data[i].mark) result += set.mabe;
                                        result += results.data[i].value;
                                        if (results.data[i].mark) result += set.maen;
                                        result += ali;
                                        ul.append(result);
                                    }
                                    if (results.total > 1) {
                                        var pages = '<li class="divider ajaxDropDownInfo"></li><li class="ajaxDropDownInfo';
                                        if (set.swcl !== '') pages += ' ' + set.swcl;
                                        pages += '"';
                                        if (set.swst !== '') pages += st + set.swst + '"';
                                        pages += '><a href="#" class="ajaxDropDownPrev';
                                        if (set.prcl !== '') pages += ' ' + set.prcl;
                                        if (results.page === 1) {
                                            pages += ' ' + dicl;
                                        }
                                        pages += '"';
                                        if (set.prst !== '') pages += st + set.prst + '"';
                                        pages += '>' + set.prbe + set.loca.prev + set.pren + '</a><a href="#" class="ajaxDropDownNext';
                                        if (set.necl !== '') pages += ' ' + set.necl;
                                        if (results.page === results.total) {
                                           pages += ' ' + dicl;
                                        }
                                        pages += '"';
                                        if (set.nest !== '') pages += st + set.nest + '"';
                                        pages += '>' + set.nebe + set.loca.next + set.neen + ali;
                                        ul.append(pages);
                                    }
                                }
                                else ul.append(nrec);
                            }
                        }).
                        always(function(){$('li.ajaxDropDownLoading').remove();});
                }
            }
        };
        this.on('show.bs.dropdown', loadData);
        this.on('click', aNext, function(e){
            e.preventDefault();
            e.stopPropagation();
            ul.find(aPrev).removeClass(dicl);
            ul.find(aNext).addClass(dicl);
            var page = bt.data('page');
            page = page * 1 + 1;
            if (ul.find(liPage + page).length) {
                ul.find(liPages).addClass(hicl);
                ul.find(liPage + page).removeClass(hicl);
                ul.find(aNext).removeClass(dicl);
            }
            else {
                var query = tx.val();
                $.post(set.url, {query:query, page:page}).
                    fail(function(){
                        ul.append(erro);
                        console.log('jQuery post failed');
                    }).
                    done(function(data){
                        var results = $.parseJSON(data);
                        if (results.data === undefined) {
                            ul.append(erro);
                            console.log('No data element in results object', data);
                        }
                        else {
                            if (results.data.length) {
                                ul.find(liPages).addClass(hicl);
                                if (results.total === undefined) results.total = 1;
                                if (results.page === undefined) results.page = 1;
                                for (var i in results.data) {
                                    var result = liPagesAll + results.page + ajRec + results.data[i].id;
                                    if (set.recl !== '') result += ' ' + set.recl;
                                    if (ul.parent().parent().parent().find(liSel + results.data[i].id).length) result += ' ' + accl;
                                    result += '"';
                                    if (set.rest !== '') result += st + set.rest + '"';
                                    result += dataId + results.data[i].id +'">';
                                    if (results.data[i].mark) result += set.mabe;
                                    result += results.data[i].value;
                                    if (results.data[i].mark) result += set.maen;
                                    result += ali;
                                    ul.find('.divider.ajaxDropDownInfo').before(result);
                                }
                                if (results.page < results.total) ul.find(aNext).removeClass(dicl);
                                else page = results.total;
                            }
                            else ul.append(nrec);
                        }
                    });
            }
            bt.data('page', page);
            ul.find(spNum).text(page);
        });
        this.on('click', aPrev, function(e){
            e.preventDefault();
            e.stopPropagation();
            ul.find(aNext).removeClass(dicl);
            ul.find(aPrev).addClass(dicl);
            var page = bt.data('page');
            page = page * 1 - 1;
            if (page < 1) page = 1;
            ul.find(liPages).addClass(hicl);
            ul.find(liPage + page).removeClass(hicl);
            if (page > 1) ul.find(aPrev).removeClass(dicl);
            bt.data('page', page);
            ul.find(spNum).text(page);
        });
        this.on('keyup', inpTxt, function(){
            window.clearTimeout(timeOut);
            $(this).parent().find(buttTogg).data('page', 1);
            $(this).parent().find(ulMenu).find(liPages).remove();
            if (set.keyt) {
                timeOut = window.setTimeout(function(){
                    btns.addClass('open');
                    loadData();
                }, set.dely);                
            }
        });
        this.on('click', 'a.ajaxDropDownResult', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var label = $(this).html();
            var arrayMode = '[]';
            if (set.smod) {
                res.html('');
                selection = [];
                $(this).parent().parent().find(liPages).removeClass(accl);
                arrayMode = '';
            }
            if (set.smod && set.addc === '' && !set.smbt) {
                bt.hide();
                rem.show();
                tx.val(label.replace(/<.*?>/g, '').replace(/"/g, "'"));
                tx.prop('disabled', true);
                if (tx.parent().find('.singleResult').length) {
                    tx.parent().find('.singleResult').val(id);
                }
                else {
                    tx.after('<input class="singleResult" type="hidden" name="' + set.name + '" value="' + id + '">');
                }
                selection.push({id:id, label:label});
                onSelect(id, label, selection);
            }
            else {
                if ($(this).parent().hasClass(accl)) {
                    $(this).parent().removeClass(accl);
                    res.find(liSel + id).remove();
                    rearrange(id);
                    onRemove(id, selection);
                }
                else {
                    $(this).parent().addClass(accl);
                    var selected = '<li class="ajaxDropDownSelected' + id;
                    if (set.rscl !== '') selected += ' ' + set.rscl;
                    selected += '"';
                    if (set.rsst !== '') selected += st + set.rsst + '"';
                    selected += '><a href="#" class="ajaxDropDownRemove';
                    if (set.rmcl !== '') selected += ' ' + set.rmcl;
                    selected += '"';
                    if (set.rmst !== '') selected += st + set.rmst + '"';
                    selected += ' data-id="' + id + '">' + set.rmla + '</a>';
                    if (set.addc !== '') {
                        var addcr = set.addc.replace(/{ID}/g, id);
                        addcr = addcr.replace(/{VALUE}/g, label);
                        selected += addcr;
                    }
                    selected += label + '<input type="hidden" name="' + set.name + arrayMode + '" value="' + id + '"></li>';
                    res.append(selected);
                    selection.push({id:id, label:label});
                    onSelect(id, label, selection);
                }
            }
        });
        this.on('click', 'a.ajaxDropDownRemove', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $(this).parent().parent().parent().find('li.ajaxDropDownRecord' + id).removeClass(accl);
            $(this).parent().remove();
            rearrange(id);
            onRemove(id, selection);
        });
        this.on('click', buttSR, function(e){
            e.preventDefault();
            var singleRes = $(this).parent().parent().find('input.singleResult');
            var id = singleRes.val();
            singleRes.remove();
            tx.prop('disabled', false);
            tx.val('');
            $(this).hide();
            bt.show();
            rearrange(id);
            onRemove(id, selection);
        });
        this.on('add', function(){
            var arrayMode = '[]';
            var selected = '';
            if (set.smod) {
                res.html('');
                selection = [];
                arrayMode = '';
            }
            for (var i in arguments) {
                if (i == 0) continue;
                if (arguments[i].id === undefined) {
                    console.log('No id element in data object', arguments[i]);
                }
                else {
                    var id = arguments[i].id;
                    if (!isin(id)) {
                        var value = '';
                        if (arguments[i].value !== undefined) value = arguments[i].value;
                        var mark = 0;
                        if (arguments[i].mark == 1) mark = 1;
                        if (mark) value = set.mabe + value + set.maen;
                        var additional = set.addc;
                        if (arguments[i].additional === false) additional = '';
                        else if (arguments[i].additional !== undefined) additional = arguments[i].additional;
                        if (set.smod && set.addc === '' && !set.smbt) {
                            bt.hide();
                            rem.show();
                            tx.val(value.replace(/<.*?>/g, '').replace(/"/g, "'"));
                            tx.prop('disabled', true);
                            if (tx.parent().find('.singleResult').length) {
                                tx.parent().find('.singleResult').val(id);
                            }
                            else {
                                tx.after('<input class="singleResult" type="hidden" name="' + set.name + '" value="' + id + '">');
                            }
                            selection.push({id:id, label:value});
                            if (set.jsev) onSelect(id, value, selection);
                        }
                        else {
                            var selected = '<li class="ajaxDropDownSelected' + id;
                            if (set.rscl !== '') selected += ' ' + set.rscl;
                            selected += '"';
                            if (set.rsst !== '') selected += st + set.rsst + '"';
                            selected += '><a href="#" class="ajaxDropDownRemove';
                            if (set.rmcl !== '') selected += ' ' + set.rmcl;
                            selected += '"';
                            if (set.rmst !== '') selected += st + set.rmst + '"';
                            selected += ' data-id="' + id + '">' + set.rmla + '</a>';
                            if (additional !== '') {
                                var addcr = additional.replace(/{ID}/g, id);
                                addcr = addcr.replace(/{VALUE}/g, value);
                                selected += addcr;
                            }
                            selected += value + '<input type="hidden" name="' + set.name + arrayMode + '" value="' + id + '"></li>';
                            if (!set.smbt) {
                                res.append(selected);
                                selection.push({id:id, label:value});
                                if (set.jsev) onSelect(id, value, selection);
                            }
                        }
                    }
                }
            }
            if (set.smbt && selected !== '') {
                res.append(selected);
                selection.push({id:id, label:value});
                if (set.jsev) onSelect(id, value, selection);
            }
        });
        this.on('removeOne', function(){
            for (var i in arguments) {
                if (i == 0) continue;
                if (isNaN(arguments[i])) {
                    console.log('id is not a number', arguments[i]);
                }
                else {
                    var id = arguments[i];
                    if (isin(id)) {
                        res.find(liSel + id).remove();
                        rearrange(id);
                        if (set.jsev) onRemove(id, selection);
                    }
                }
            }
        });
        this.on('removeAll', function(){
            res.html('');
            selection = [];
        });
        return this;
    };
}(jQuery));
