$(function() {

    function getAuthorsList() {
        $.getJSON({
            url: "http://localhost/Bookstore/rest/rest.php/author"
        }).done(function(authorsList) {
            var html = '';
            authorsList.success.forEach(function(author) {
                var bookList = '';
                author.books.forEach(function(book) {
                    bookList += '<li>'+book.title+'</li>'; 
                });
                if(bookList === '') {bookList = "Autor nie ma jeszcze książek";}
                html += '<li class="list-group-item" data-id="'+author.id+'">'+
                            '<div class="panel panel-default">'+
                                '<div class="panel-heading"><span class="authorTitle">'+author.name+' '+author.surname+'</span>'+
                                    '<button data-id="'+author.id+'" class="btn btn-danger pull-right btn-xs btn-author-remove"><i class="fa fa-trash"></i></button>'+
                                    '<button data-id="'+author.id+'" class="btn btn-primary pull-right btn-xs btn-author-books"><i class="fa fa-book"></i></button>'+
                                '</div>'+
                                '<ul class="authorBooksList">'+bookList+'</ul>'+
                            '</div>'+
                        '</li>';
                fullfilSelectElement(authorsList.success);
                $('#authorsList').html(html);
            });
         
        }).fail(function(a,b,c) {
            console.log("Error",a,b,c);
        });
    }
    
    function activateDescriptionToggle() {
        $('#authorsList').on('click', '.btn-author-books', function(event) {
            $('.list-group-item[data-id="'+event.target.dataset.id+'"]').find('.authorBooksList').toggle(2000);
        });
    }
    
    function activateAuthorAdding() {
        var authorAddForm = document.querySelector('#authorAdd');
        
        authorAddForm.addEventListener('submit', function(event) {
            
            $.post({
                url: "http://localhost/Bookstore/rest/rest.php/author",
                data: $(authorAddForm).serialize()
            }).done(function(formData) {
                authorAddForm.reset();
                showModal('New author was added');
                getAuthorsList();
            }).fail(function(a,b,c) {
                console.log("Error", a,b,c);
            });
            event.preventDefault();
            
        });
    }
    
    function acivateAuthorEditing() {
        var authorEditForm = $('#authorEdit');
        
        $('#authorEditSelect').on('change', function(event) {
            var authorId = event.target.value;
            console.log(authorId);
            if(authorId.length === 0) {
                authorEditForm.slideUp();
            }
            else {
                authorEditForm.slideDown();
                $.getJSON({
                    url: "http://localhost/Bookstore/rest/rest.php/author/"+authorId
                }).done(function(authorArray) {
                    var authorData = authorArray.success[0];
                    
                    authorEditForm[0].dataset.id = authorData.id;
                    authorEditForm.find('input[name=name]').val(authorData.name);
                    authorEditForm.find('input[name=surname]').val(authorData.surname);
                }).fail();
            }
        });
        
        authorEditForm.on('submit', function(event) {
            var authorId = this.dataset.id;
            
            $.ajax({
                url: "http://localhost/Bookstore/rest/rest.php/author/"+authorId,
                data: $(authorEditForm).serialize(),
                method: 'PATCH'
            }).done(function() {
                showModal('Author data have been modified');
                getAuthorsList();
            }).fail(function(a,b,c) {
                console.log("Error",a,b,c);
            });
            event.preventDefault();
            
        });
    }
    
    function activateAuthorDeleting() {
        $('#authorsList').on('click', '.btn-author-remove', function(event) {
           var authorId = event.target.dataset.id;
           $.ajax({
               url: "http://localhost/WAR_PHP_W_08_Warsztat_3v2/rest/rest.php/author/"+authorId,
               method: 'DELETE'
           }).done(function() {
               showModal('Author has been deleted');
               getAuthorsList();
           }).fail(function(a,b,c) {
               console.log('Error', a,b,c);
           });
       });
    }
    
    function fullfilSelectElement(authorsList){
        var html = '<option value=""> -- Select Author for edit --</option>';
        authorsList.forEach(function(author) {
            html += '<option value="'+author.id+'">'+author.name+' '+author.surname+'</option>';
        });
        $('#authorEditSelect').html(html);
    }
    
    function init() {
        getAuthorsList();
        activateDescriptionToggle();
        activateAuthorAdding();
        acivateAuthorEditing();
        activateAuthorDeleting();
    }
    
    init();
});