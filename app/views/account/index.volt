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
            <div class="modal-body"> Widget settings form goes here </div>
        </div>
        <div class="clearfix"></div>
        <div class="content sm-gutter">
            <div class="row" >

                <!-- BEGIN REALTIME SALES GRAPH -->
                <div class="col-md-4 col-vlg-4 m-b-10 ">
                    <div class="tiles white">
                        <div class="row">
                            <div class="sales-graph-heading">
                                <div class="col-md-5 col-sm-5">
                                    <h5 class="no-margin">Баланс</h5>
                                    <h4><span class="item-count animate-number semi-bold" data-value="{{ user.getBalance() }}" data-animation-duration="700">0</span> UAH</h4>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <p class="semi-bold">За сьогодні</p>
                                    <h4><span class="item-count animate-number semi-bold" data-value="{{ user.getBalanceToday() }}" data-animation-duration="700">0</span> UAH</h4>
                                </div>
                                <div class="col-md-4 col-sm-3">
                                    <p class="semi-bold">Цього місяця</p>
                                    <h4><span class="item-count animate-number semi-bold" data-value="{{ user.getBalanceMonth() }}" data-animation-duration="700">0</span> UAH</h4>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <h5 class="semi-bold m-t-30 m-l-30">Останні 5 операцій</h5>
                        <table class="table no-more-tables m-t-20 m-l-20 m-b-30">
                            <thead style="display:none">
                            <tr>
                                <th style="width:9%">Project Name</th>
                                <th style="width:22%">Description</th>
                                <th style="width:6%">Price</th>
                                <th style="width:1%"> </th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for transaction in transactions %}
                            <tr>
                                <td class="v-align-middle bold {% if transaction.isIncome() %}text-success {% endif %}"> {{ transaction.getAmount() }}</td>
                                <td class="v-align-middle"> {{ transaction.getComment() }}</td>
                                <td class="v-align-middle"><a href="{{ url.get('transactions/' ~ transaction.getId() ~ '/edit') }}">{{ transaction.getCreatedAt() }}<a/></td>
                                {% set category = transaction.getCategory() %}
                                <td class="v-align-middle">{% if category %}{{ category.getName() }} {% endif %}</td>
                            </tr>
                            {% endfor %}
                            </tbody>
                        </table>
                        <div id="sales-graph"> </div>
                        <div class="row">
                            <a class="btn btn-block btn-primary" href="{{ url.get('/transactions/create') }}" type="button"><i class="fa fa-plus"></i> Додати операцію</a>
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


        </div>
    </div>
</div>

{{ assets.outputJs() }}
</body>