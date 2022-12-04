$(function () {

    $("#table-export-bttn").on('click',function(evt){
        var tablesel=$(this).data('table');
        $(tablesel).table2csv({
            separator:',',
            newline:'\n',
            quoteFields:true,
            excludeColumns:'',
            excludeRows:'',
            trimContent:true // Trims the content of individual <th>, <td> tags of whitespaces.
          });
    });
    
        
});

