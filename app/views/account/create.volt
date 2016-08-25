<body class="">

{{ partial('header') }}

<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
    {{ partial('sidebar') }}
    <!-- BEGIN PAGE CONTAINER-->
    <div class="page-content condensed">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <form method="post">
                        <div class="row text-center">
                            <h1>Додати рахунок</h1>

                            {{ content() }}

                            <div class="form-group col-md-4 col-md-offset-4 col-xs-12">
                                <label for="comment">Назва</label>
                                <div class="input-group transparent">
                                    <span class="input-group-addon">
                                      <i class="fa fa-tag"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                            </div>

                            <div class="form-group col-md-4 col-md-offset-4 col-xs-12">
                                <button type="submit" class="btn btn-success">Підтвердити</button>
                            </div>
                            <div class="form-group col-md-4 col-md-offset-4 col-xs-12">
                                <a href="{{ url.get("/transactions") }}" class="btn btn-success">Відмінити</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{ assets.outputJs() }}
</body>