<div class="row voffset5">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <form role="form" id="bookAdd">
            <legend>Add book</legend>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Title...">
            </div>
            <div class="form-group">
                <label for="title">Author</label>
                <select name="author_id" id="author_id" class="form-control">
                    <option value=""> -- Select Author --</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="5"
                          placeholder="Description..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-book"></i>&nbsp;Add</button>
        </form>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
</div>
<div class="row voffset5">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <select name="bookEditSelect" id="bookEditSelect" class="form-control">
            <option value=""> -- Select Book for edit --</option>
        </select>
        <form role="form" id="bookEdit">
            <input type="hidden" name="id" id="id" value="">
            <legend class="voffset2">Edit book</legend>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Title...">
            </div>
            <div class="form-group">
                <label for="title">Author</label>
                <select name="author_id" id="author_id_edit" class="form-control">
                    <option value=""> -- Select Author --</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="5"
                          placeholder="Description..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-book"></i>&nbsp;Edit</button>
        </form>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
</div>
<div class="row voffset5">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <div class="panel panel-primary">
            <div class="panel-heading">Books list</div>
            <div class="panel-body">
                <ul class="list-group" id="booksList">
                    <!--                    EXAMPLE BOOK START-->
                    <!--                    <li class="list-group-item">-->
                    <!--                        <div class="panel panel-default">-->
                    <!--                            <div class="panel-heading">-->
                    <!--                                <span class="bookTitle">Example book 1 (author)</span>-->
                    <!--                                <button data-id="1"-->
                    <!--                                        class="btn btn-danger pull-right btn-xs btn-book-remove"><i-->
                    <!--                                        class="fa fa-trash"></i>-->
                    <!--                                </button>-->
                    <!--                                <button data-id="1"-->
                    <!--                                        class="btn btn-primary pull-right btn-xs btn-book-show-description"><i-->
                    <!--                                        class="fa fa-info-circle"></i>-->
                    <!--                                </button>-->
                    <!--                            </div>-->
                    <!--                            <div class="panel-body book-description"></div>-->
                    <!--                        </div>-->
                    <!--                    </li>-->
                    <!--                    EXAMPLE BOOK END-->
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
</div>