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

$( ".accLine" ).click(function() { 
    window.location = 'account.php?id=' + $(this).data("id");
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