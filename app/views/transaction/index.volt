<body class="">

{{ partial('header') }}

<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
    {{ partial('sidebar') }}
    <!-- BEGIN PAGE CONTAINER-->
    <div class="page-content condensed">
        <div id="portlet-config" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"></button>
                <h3>Widget Settings</h3>
            </div>
            <div class="modal-body"> Widget settings form goes here </div>
        </div>
        <div class="clearfix"></div>

        <div class="content">
            <div class="page-title" style="display:none"> <a href="#" id="btn-back"><i class="icon-custom-left"></i></a>
                <h3>Back- <span class="semi-bold">Усі операції</span></h3>
            </div>
            <div class="row"  id="inbox-wrapper">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="grid simple" >
                                <div class="grid-body no-border email-body" >
                                    <br>
                                    <div class="row-fluid" >
                                        <div class="row-fluid dataTables_wrapper">
                                            <a class="btn btn-block btn-primary" href="{{ url.get('/transactions/create') }}" type="button"><i class="fa fa-plus"></i> Додати операцію</a>
                                            <h2 class=" inline">Усі операції </h2>

                                            {{ content() }}

                                            <div class="pull-right margin-top-20">
                                                <div class="dataTables_paginate paging_bootstrap pagination">
                                                    <ul>
                                                        <li ><a href="?page=">Перша сторінка</a></li>
                                                        <li class="prev disabled"><a href="?page={{ page.before }}"><i class="fa fa-chevron-left"></i></a></li>
                                                        <li class="next"><a href="?page={{ page.next }}"><i class="fa fa-chevron-right"></i></a></li>
                                                        <li><a href="?page={{ page.last }}">Остання сторінка</a></li>
                                                    </ul>
                                                </div>
                                                <div class="dataTables_info hidden-xs" id="example_info">Показано з <b>1 по 5</b> операції на {{ page.total_pages }} сторінці </div></div>
                                        <div id="email-list">
                                            <table class="table table-striped table-fixed-layout table-hover" id="emails" >
                                                <thead>
                                                <tr>
                                                    <th width="30%">{{ account.getCurrency().getName() }}</th>
                                                    <th width="30%">Примітка</th>
                                                    <th width="30%">Дата</th>
                                                    <th width="10%">Категорія</th>
                                                    <th width="10%">Рахунок</th>
                                                    <th width="10%">Видалити</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {% for transaction in page.items %}
                                                    <tr  onclick="window.document.location='{{ url.get('transactions/' ~ transaction.getId() ~ '/edit') }}';">
                                                        <td class="v-align-middle bold {% if transaction.isIncome() %}text-success {% endif %}" >{{ transaction.getAmountDigit() }}</td>
                                                        <td class="v-align-middle"><span class="muted">{{ transaction.getComment() }}</span></td>
                                                        <td class="v-align-middle"><span class="muted">{{ transaction.getCreatedAt() }}</span></td>
                                                        {% set category = transaction.getCategory() %}
                                                        <td class="v-align-middle">{% if category %}{{ category.getName() }} {% endif %}</td>
                                                        <td class="v-align-middle">{{ account.getName() }}</td>
                                                        <td class="v-align-middle"> <a href="{{ url.get('transactions/' ~ transaction.getId() ~ '/remove') }}"><i class="fa fa-times"></i></a> </td>
                                                    </tr>
                                                {% endfor %}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" id="preview-email-wrapper" style="display:none">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="grid simple">
                                <div class="grid-title no-border">
                                    <h4></h4>
                                    <div class="tools">
                                        <a href="javascript:;" class="remove"></a>
                                    </div>
                                </div>
                                <div class="grid-body no-border" style="min-height: 850px;">
                                    <div class="" >
                                        <h1 id="emailheading">Meeting</h1>
                                        <br>
                                        <div class="control">
                                            <div class="pull-left">
                                                <div class="btn-group">
                                                    <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                                        David Nester
                                                        <span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else here</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#">Separated link</a></li>
                                                    </ul>
                                                </div>
                                                <label class="inline"><span class="muted">&nbsp;&nbsp;to</span> <span class="bold small-text">johnsmith@skyace.com</span></label>
                                            </div>
                                            <div class="pull-right">
                                                <span class="muted small-text">August 5 2013 11.30PM</span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <br>
                                        <div class="email-body">
                                            <p>Thank you for taking the time to meet with me and other representatives of the last week regarding the challenges facing public transportation, especially. We enjoyed meeting with you and . I’m glad we had the opportunity to discuss an issue that affects so many people in [city/state/community]. We especially appreciate your commitment to [describe any commitment made by the official].
                                                The [coalition name] believes that public transportation is vital to quality of life of our community. As we discussed …
                                                Our coalition would greatly appreciate your support  in ensuring that public transportation is widely available to all who need it – especially the people living in . On behalf of all our members and the thousands of citizens they represent, I want to thank you for taking the time out of your busy schedule to discuss this important matter.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="admin-bar" id="quick-access" style="display:">
            <div class="admin-bar-inner">

                <button class="btn btn-danger  btn-add" type="button"><i class="icon-trash"></i> Move to trash</button>
                <button class="btn btn-white  btn-cancel" type="button">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{ assets.outputJs() }}
</body>