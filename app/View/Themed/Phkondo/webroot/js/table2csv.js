$(function () {

    $(".table-export-btn").on('click',function(evt){
        var tableelem=$(this).data('table');
        $(tableelem).table2csv({
            separator:',',
            newline:'\n',
            quoteFields:true,
            excludeColumns:'',
            excludeRows:'',
            trimContent:true // Trims the content of individual <th>, <td> tags of whitespaces.
          });
    });
    
        
});

