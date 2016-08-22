<body class="error-body no-top">
<div class="container">
    <div class="row login-container column-seperation">
        <div class="col-md-5 "> <br>
            <h1>Реєстрація</h1>
            <form id="login-form" class="login-form" method="post">
                {% if error is defined %}
                    <div class="alert alert-error">
                        <button class="close" data-dismiss="alert"></button>
                        {{ error }}
                    </div>
                {% endif %}
                <div class="row">
                    <div class="form-group col-md-10">
                        <label class="form-label">Email</label>
                        <div class="controls">
                            <div class="input-with-icon  right">
                                <i class=""></i>
                                <input type="text" name="email" id="txtusername" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-10">
                        <label class="form-label">Ім’я користувача</label>
                        <div class="controls">
                            <div class="input-with-icon  right">
                                <i class=""></i>
                                <input type="text" name="name" id="txtusername" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-10">
                        <label class="form-label">Password</label>
                        <span class="help"></span>
                        <div class="controls">
                            <div class="input-with-icon  right">
                                <i class=""></i>
                                <input type="password" name="password" id="txtpassword" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <button class="btn btn-primary btn-cons pull-right" type="submit">Зареєструватись</button>
                    </div>
                </div>
            </form>
        </div>

        {{ content() }}

    </div>
</div>
{{ assets.outputJs() }}
</body>