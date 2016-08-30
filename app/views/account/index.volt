<body class="">

{{ partial('header') }}

<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
    {{ partial('sidebar') }}
    <!-- BEGIN PAGE CONTAINER-->
    <div class="page-content condensed">

        {{ content() }}

        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div id="portlet-config" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"></button>
                <h3>Widget Settings</h3>
            </div>
            <div class="modal-body"> Widget settings form goes here</div>
        </div>
        <div class="clearfix"></div>
        <div class="content sm-gutter">
                <!-- BEGIN REALTIME SALES GRAPH -->
            <div class="row">
                <form method="post">
                <div class="form-group col-md-4 col-xs-12">
                    <label for="comment">Виберіть рахунок</label>
                    <div class="input-group transparent">
                        <input type="hidden" value="" style="width:300px" id="e12" tabindex="-1" class="select2-offscreen">
                        {{ select("selected_account_id", user.getAccount(), 'using': ['id', 'name'], 'value': selectedAccount.getId()) }}
                    </div>
                    <div class="form-group col-md-4 col-xs-12">
                        <button type="submit" class="btn btn-success">Вибрати</button>
                    </div>
                    <div class="form-group col-md-4 col-xs-12">
                        <a href="{{ url.get("/account/show") }}" class="btn btn-success">Перегляд руханків</a>
                    </div>
                </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-6 col-vlg-4 m-b-10 ">
                    <div class="tiles white">
                        <div class="row">
                            <div class="sales-graph-heading">
                                <div class="col-md-5 col-sm-5">
                                    <h5 class="no-margin">Баланс</h5>
                                    <h4><span class="item-count animate-number semi-bold"
                                              data-value="{{ selectedAccount.getBalance() }}"
                                              data-animation-duration="700">0</span> {{ selectedAccount.getCurrency().getName() }}</h4>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <p class="semi-bold">За сьогодні</p>
                                    <h4><span class="item-count animate-number semi-bold"
                                              data-value="{{ selectedAccount.getBalanceToday() }}"
                                              data-animation-duration="700">0</span> {{ selectedAccount.getCurrency().getName() }}</h4>
                                </div>
                                <div class="col-md-4 col-sm-3">
                                    <p class="semi-bold">Цього місяця</p>
                                    <h4><span class="item-count animate-number semi-bold"
                                              data-value="{{ selectedAccount.getBalanceMonth() }}"
                                              data-animation-duration="700">0</span> {{ selectedAccount.getCurrency().getName() }}</h4>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <h5 class="semi-bold m-t-30 m-l-30">Останні 5 операцій</h5>
                        <table  class="table table-striped table-fixed-layout table-hover" id="emails" >
                            <thead style="display:none">
                            <tr>
                                <th style="width:25%">Project Name</th>
                                <th style="width:22%">Description</th>
                                <th style="width:20%">Price</th>
                                <th style="width:10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for transaction in transactions %}
                                <tr  onclick="window.document.location='{{ url.get('transactions/' ~ transaction.getId() ~ '/edit') }}';">
                                    <td class="v-align-middle bold {% if transaction.isIncome() %}text-success {% endif %}"> {{ transaction.getAmount() }}</td>
                                    <td class="v-align-middle"> {{ transaction.getComment() }}</td>
                                    <td class="v-align-middle">{{ transaction.getCreatedAt() }}</td>
                                    {% set category = transaction.getCategory() %}
                                    <td class="v-align-middle">{% if category %}{{ category.getName() }} {% endif %}</td>
                                    {% set account = transaction.getAccount() %}
                                    <td class="v-align-middle">{% if account %}{{ account.getName() }} {% endif %}</td>
                                </tr>
                            {% endfor %}
                            </tbody>
                        </table>
                        <div id="sales-graph"></div>
                        <div class="row">
                            <a class="btn btn-block btn-primary" href="{{ url.get('/transactions/create') }}"
                               type="button"><i class="fa fa-plus"></i> Додати операцію</a>
                        </div>
                    </div>
                </div>
                <!-- END REALTIME SALES GRAPH -->
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="row text-center">
                        <a href="{{ url.get('/transactions') }}">Переглянути усі операції</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="grid simple">
                        <div class="grid-title no-border">
                            <h4>Мої <span class="semi-bold">Розходи</span></h4>
                            <div class="tools"> <a href="javascript:;" class="collapse"></a>
                                <a href="#grid-config" data-toggle="modal" class="config"></a>
                                <a href="javascript:;" class="reload"></a>
                                <a href="javascript:;" class="remove"></a> </div>
                        </div>
                        <div class="grid-body no-border">
                            <div id="sparkline-pie" class="col-md-12" data-value="[{{ amounts_string }}]"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ assets.outputJs() }}
</div>
</body>