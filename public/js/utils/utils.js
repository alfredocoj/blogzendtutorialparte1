/*Função que seta uma opção no select de acordo com a base de dados*/
function setSelected( jqueryOptionsSelect, id )
{
    jqueryOptionsSelect.filter(function() {
        return $(this).val() == id;
    }).attr('selected', true);
}

/*Função que retorna uma lista ordenada de valores de acordo com um json de dados.*/
function makeUnorderedList(jsonData)
{
    var ul = $('<ul>',{});
    for(index in jsonData)
    {
        var li         = $('<li>', {});
        var blockquote = $('<blockquote>', {});
        var p          = $('<p>', {});
        var footer     = $('<footer>', {});

        p.text(jsonData[index].description);
        footer.text(" - "+jsonData[index].author);

        blockquote.append(p).append(footer);
        li.append(blockquote);
        ul.append(li);
    }

    return ul;
}
