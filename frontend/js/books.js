$(function() {
    console.log('ok');
    function getBooksList() {
        $.getJSON({
            url: "http://localhost/Bookstore/rest/rest.php/book"
        }).done(function(booksList) {
            console.log(booksList.success);
            console.log(booksList.success[0].author_id);
            console.log(booksList.success[0].author.name);
            var html = '';
            booksList.success.forEach(function(book) {
                html += '<li class="list-group-item" data-id="'+book.id+'">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading">'+
                                    '<span class="bookTitle">'+book.title+' ('+book.author.name+' '+book.author.surname+')</span>'+
                                    '<button data-id="'+book.id+'" class="btn btn-danger pull-right btn-xs btn-book-remove"><i class="fa fa-trash"></i></button>'+
                                    '<button data-id="'+book.id+'" class="btn btn-primary pull-right btn-xs btn-book-show-description"><i class="fa fa-info-circle"></i></button>'+
                                '</div>'+
                                '<div class="panel-body book-description">'+book.description+'</div>'+
                            '</div>'+
                        '</li>';

                fulfillSelectElement(booksList.success);
                
                $('#booksList').html(html);
            });
        }).fail(function(a,b,c) {
            console.log("Error",a,b,c);
        });
    }
    
    function activateBookAdding() {
        var bookAddForm = document.querySelector('#bookAdd');
        
        bookAddForm.addEventListener('submit', function(event) {
                  
            $.post({
                url: "http://localhost/Bookstore/rest/rest.php/book",
                data: $(bookAddForm).serialize()
            }).done(function(formData) {
                bookAddForm.reset();
                showModal('Your book was added');
                getBooksList();
            }).fail(function(a,b,c) {
                console.log("Error", a,b,c);
            });
            event.preventDefault();

        });
    }
    
    function activateBookDeleting() {
       $('#booksList').on('click', '.btn-book-remove', function(event) {
           var bookId = event.target.dataset.id;
           $.ajax({
               url: "http://localhost/Bookstore/rest/rest.php/book/"+bookId,
               method: 'DELETE'
           }).done(function() {
               showModal('Your book has been deleted');
               getBooksList();
           }).fail(function(a,b,c) {
               console.log('Error', a,b,c);
           });
       });
    }
   
    function activateBookEditing() {
        var bookEditForm = $('#bookEdit');
        
        $('#bookEditSelect').on('change', function(event) {
            var bookId = event.target.value;
            
            if(bookId.length === 0) {
                bookEditForm.slideUp();
            }
            else {
                bookEditForm.slideDown();
                $.getJSON({
                    url: "http://localhost/Bookstore/rest/rest.php/book/"+bookId
                }).done(function(bookArray) {
                    var bookData = bookArray.success[0];
                    
                    bookEditForm[0].dataset.id = bookData.id;
                    bookEditForm.find('input[name=title]').val(bookData.title);
                    bookEditForm.find('textarea[name=description]').val(bookData.description);
                }).fail(function(a,b,c) {
                    console.log("Error",a,b,c);
                });
            }
        });
        
        bookEditForm.on('submit', function(event) {
            var bookId = this.dataset.id;
            
            $.ajax({
                url: "http://localhost/Bookstore/rest/rest.php/book/"+bookId,
                method: 'PATCH',
                data: bookEditForm.serialize()
            }).done(function() {
                showModal('Book data updated');
                getBooksList();
            }).fail(function(a,b,c) {
                console.log("Error",a,b,c);
            });
            event.preventDefault();
        });
    }

    function activateDescriptionToggle() {
        $('#booksList').on('click', '.btn-book-show-description', function(event) {
            $('.list-group-item[data-id="'+event.target.dataset.id+'"]').find('.panel-body.book-description').toggle(2000);
        });
    }
   
    function fulfillSelectElement(bookList) {
       var bookHtml = '<option value=""> -- Select Book for edit --</option>';

       bookList.forEach(function(book) {
           bookHtml += '<option value="'+book.id+'">'+book.title+'</option>';
       });

       document.querySelector('#bookEditSelect').innerHTML = bookHtml;
    }
    
    function getAuthorsListForSelectElements() {
        $.getJSON({
            url: "http://localhost/Bookstore/rest/rest.php/author"
        }).done(function(authorsList) {
            console.log(authorsList);
            var authorHtml = '<option value=""> -- Select Author --</option>';
       
            authorsList.success.forEach(function(author) {
               authorHtml += '<option value="'+author.id+'">'+author.name+' '+author.surname+'</option>';
            });

            document.querySelector('#author_id').innerHTML = authorHtml;
            document.querySelector('#author_id_edit').innerHTML = authorHtml;
            
        }).fail(function(a,b,c) {
            console.log("Error",a,b,c);
        });
    }
    
    function init() {
        getBooksList();
        getAuthorsListForSelectElements();
        activateBookAdding();
        activateBookDeleting();
        activateBookEditing();
        activateDescriptionToggle();
    }
    
    init();

});