function getGetParam(filter) {
    var params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            var a = e.split('=');
            p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
            return p;
        },
        {}
    );

    let getStr = '';
    for (key in params) {
        if(key == 'filter'){
            params[key] = filter;
        }
        getStr += '&' + key + '=' + params[key];
    }
    return getStr.replace('&', '?');
}

$( "#addAccountButton" ).click(function() { 
    $('#addAccountForm').submit(function (e) {
        e.preventDefault();               
        $.ajax({
            url: "add-account.php",
            type: "POST",
            data: $('#addAccountForm').serialize(),
            success: function (response) {

                result = jQuery.parseJSON(response);
                alert(result);  

            },
            error: function (response) {
                alert('Ошибка');
            },
        });
    });
});

$( "#delAccount" ).click(function() {
    if($(this).data("status") == 0){
        isDelete = confirm("Удалить счёт?");
    }
    if($(this).data("status") == 1){
        isDelete = confirm("В архив?");
    }
    if($(this).data("status") == 2){
        isDelete = confirm("Активировать счёт?");
    }
    
    if(isDelete){
        $.ajax({
            url: "delete-account.php",
            type: "POST",
            data: {
                'accountId': $(this).data("id"),
                'accountStatus': $(this).data("status")
            },
            success: function (response) {
                result = jQuery.parseJSON(response);
                if(result == 'Deleted'){
                    window.location = '/';
                }else{
                    document.location.reload();
                    alert(result);
                }
            },
            error: function (response) {
                alert('Ошибка');
            },
        });
    }
});


$( "#addIncomeButton" ).click(function() { 
    $('#addIncomeForm').submit(function (e) {
        e.preventDefault();               
        $.ajax({
            url: "add-income.php",
            type: "POST",
            data: $('#addIncomeForm').serialize(),
            success: function (response) {

                result = jQuery.parseJSON(response);
                alert(result);  

            },
            error: function (response) {
                alert('Ошибка');
            },
        });
    });
});

$( "#addExpenseButton" ).click(function() { 
    $('#addExpenseForm').submit(function (e) {
        e.preventDefault();               
        $.ajax({
            url: "add-expense.php",
            type: "POST",
            data: $('#addExpenseForm').serialize(),
            success: function (response) {

                result = jQuery.parseJSON(response);
                alert(result);  

            },
            error: function (response) {
                alert('Ошибка');
            },
        });
    });
});

$( "#addCategoryButton" ).click(function() { 
    $('#addCategoryForm').submit(function (e) {
        e.preventDefault();               
        $.ajax({
            url: "add-category.php",
            type: "POST",
            data: $('#addCategoryForm').serialize(),
            success: function (response) {

                result = jQuery.parseJSON(response);
                alert(result['message']);
                window.location = result['url'];

            },
            error: function (response) {
                alert('Ошибка');
            },
        });
    });
});

$( "#addSubCategoryButton" ).click(function() {
    let subCategoryCount = ((document.getElementById('addSubCategoryBlock')).getElementsByTagName('input')).length + 1;

    if (subCategoryCount <= 5){
        $('#addSubCategoryBlock').html($('#addSubCategoryBlock').html() + 
            '<div id="addSubCategoryLine' + (subCategoryCount) + '"><input id="addSubCategory' + (subCategoryCount) + '" class="addCategoryInput addSubCategoryInput" name="addSubCategory' + (subCategoryCount) + '" type="text" maxlength="64" placeholder="Название подкатегории">' +
            '<div id="delSubCategory' + (subCategoryCount) + '" class="delSubCategory" data-id="' + (subCategoryCount) + '" onclick="delSubCategory(this);"><img src="img/can.png" alt="delSubCategory"></div></div>'
        );
        
        $('#subCategoriesCount').val(subCategoryCount);
    }
    if(subCategoryCount == 5){
        $('#addSubCategoryButton').html('');
    }

});

function delSubCategory(obj) {
    let lineId = $('#subCategoriesCount').val();
    $('#addSubCategoryLine' + lineId).remove();
    $('#subCategoriesCount').val( $('#subCategoriesCount').val() - 1 );

    if(lineId <= 5){
        $('#addSubCategoryButton').html( '<div id="addSubCategoryButton" class="checkboxBlock"><div class="addSubCategoryButton"><img src="img/add.png" alt=""></div><div class="addSubCategoryTitle">Добавить подкатегорию</div></div>' );
    }
}

$( ".accLine" ).click(function() { 
    window.location = 'account.php?id=' + $(this).data("id") + '&page=income&filter=Month';
});

$( "#categoryName" ).on('input', function() {
    if(this.value != ''){
        $("#addCategoryButton").removeClass('disabledButton');
        $("#addCategoryButton").prop( "disabled", false );
    }else{
        $("#addCategoryButton").addClass('disabledButton');
        $("#addCategoryButton").prop( "disabled", true ); 
    }
});

$( "#sidePageClose" ).click(function() {
    $("#sideMenu").fadeOut(500);
});

$( "#menu" ).click(function() {
    $("#sideMenu").fadeIn(500);
});

function chooseCategory(obj) {
    let table = obj.name;
    $('#chooseSubCat').html('');
    $.ajax({
        type: 'POST',
        url: '../ajax.php',
        data: {
            'catId': obj.value,
            'table': table
        },
        success: function(data) {
            if(data){
                var obj = JSON.parse(data);               
                $('#chooseSubCat').append($("<option></option>").attr("value",'0').text('Под категория').attr("style",'display:none;'));
                $.each(obj, function( index, value ) {
                    $('#chooseSubCat').append($("<option></option>").attr("value",value).text(index));                    
                }); 
                $('#chooseSubCat').attr("disabled",false);
            }else{
                $('#chooseSubCat').append($("<option></option>").attr("value",'0').text('Нет под категории').attr("style",'display:none;'));
                $('#chooseSubCat').attr("disabled",true);
            }
        }
    });
}

function accChoose(obj) {
    $.ajax({
        type: 'POST',
        url: '../ajax.php',
        data: {'accountId': obj.value},
        success: function(data) {
            if(data){
                var currency = JSON.parse(data);
                $('#addCurrency').attr("placeholder",currency['lettcode']);
                $('#addCurrencyId').attr("value",currency['id']);
            }
        }
    });
}

function changeAccountPage(obj) {
    if(obj.id == 'accIncomesPage'){
        pageName = 'income';
    }
    if(obj.id == 'accExpensesPage'){
        pageName = 'expense';
    }

    if(!(obj.classList.contains('accPageActive'))){
        var params = window
        .location
        .search
        .replace('?','')
        .split('&')
        .reduce(
            function(p,e){
                var a = e.split('=');
                p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                return p;
            },
            {}
        );

        let getStr = '';
        for (key in params) {
            if(key == 'page'){
                params[key] = pageName;
            }
            getStr += '&' + key + '=' + params[key];
        }

        newGetStr = getStr.replace('&', '?');

        if (history.pushState) {
            var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            var newUrl = baseUrl + newGetStr;
            history.pushState(null, null, newUrl);
            document.location.reload();
        }
        else {
            console.warn('History API не поддерживается');
        }
    }
}

function changeFilter(obj) {
    if(!(obj.classList.contains('incomeFilterItemActive'))){
        let newGetStr = getGetParam(obj.id);

        if (history.pushState) {
            var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            var newUrl = baseUrl + newGetStr;
            history.pushState(null, null, newUrl);
        }
        else {
            console.warn('History API не поддерживается');
        }
    document.location.reload();
    }
}

function changeCatTab(obj) {
    let categoryIncomeTab = document.getElementById('categoryIncomeTab');
    let categoryExpenseTab = document.getElementById('categoryExpenseTab');

    if( !(obj.classList.contains('tabActive')) ){
        if(obj.id == 'categoryIncomeTab'){            
            categoryIncomeTab.classList.add('tabActive');
            categoryExpenseTab.classList.remove('tabActive');
            newGetStr = '?cat=incomecategory';
        }

        if(obj.id == 'categoryExpenseTab'){
            categoryIncomeTab.classList.remove('tabActive');
            categoryExpenseTab.classList.add('tabActive');
            newGetStr = '?cat=expensecategory';
        }
    }

    if (history.pushState) {
        var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        var newUrl = baseUrl + newGetStr;
        history.pushState(null, null, newUrl);
        document.location.reload();
    }
    else {
        console.warn('History API не поддерживается');
    }
}

function deleteCategory(catId, catTable, subCatTable, table) {
    let isDelete = confirm("Удалить категорию?");
    if(isDelete){    
        $.ajax({
            type: 'POST',
            url: 'del-category.php',
            data: {
                'categoryId': catId,
                'catTable': catTable,
                'subCatTable': subCatTable,
                'table': table,
            },
            success: function (response) {
                result = jQuery.parseJSON(response);
                alert(result['message']);
                document.location.reload();
            },
            error: function (response) {
                alert('Ошибка');
            },
        });
    }
}

function archCategory(catId, catTable, subCatTable) {
    let isArchive = confirm("Архивировыть категорию?");
    if(isArchive){    
        $.ajax({
            type: 'POST',
            url: 'arch-category.php',
            data: {
                'categoryId': catId,
                'catTable': catTable,
                'subCatTable': subCatTable,
            },
            success: function (response) {
                result = jQuery.parseJSON(response);
                alert(result['message']);
                document.location.reload();
            },
            error: function (response) {
                alert('Ошибка');
            },
        });
    }
}

function actCategory(catId, catTable, subCatTable, table) {
    let isActivate = confirm("Активировать категорию?");
    if(isActivate){    
        $.ajax({
            type: 'POST',
            url: 'act-category.php',
            data: {
                'categoryId': catId,
                'catTable': catTable,
                'subCatTable': subCatTable,
                'table': table,
            },
            success: function (response) {
                result = jQuery.parseJSON(response);
                alert(result['message']);
                document.location.reload();
            },
            error: function (response) {
                alert('Ошибка');
            },
        });
    }
}