<div class="page-header"><h3>{{translate 'Administration' scope='Admin'}}</h3></div>

<div class="admin-content">
    <div class="row">
        <div class="col-md-7">
            <div class="admin-search-container">
                <input
                    type="text"
                    maxlength="64"
                    placeholder="{{translate 'Search'}}"
                    data-name="quick-search"
                    class="form-control"
                    spellcheck="false"
                >
            </div>
            <div class="admin-tables-container">
                {{#each panelDataList}}
                <div class="admin-content-section" data-index="{{@index}}">
                    <h4>{{label}}</h4>
                    <table class="table table-admin-panel" data-name="{{name}}">
                        {{#each itemList}}
                        <tr class="admin-content-row" data-index="{{@index}}">
                            <td>
                                <div>
                                {{#if iconClass}}
                                <span class="icon {{iconClass}}"></span>
                                {{/if}}
                                <a
                                    {{#if url}}href="{{url}}"{{else}}role="button"{{/if}}
                                    tabindex="0"
                                    {{#if action}} data-action="{{action}}"{{/if}}
                                >{{label}}</a>
                                </div>
                            </td>
                            <td>{{translate description scope='Admin' category='descriptions'}}</td>
                        </tr>
                        {{/each}}
                    </table>
                </div>
                {{/each}}
                <div class="no-data hidden">{{translate 'No Data'}}</div>
            </div>
        </div>
        <div class="col-md-5 admin-right-column">
            <div class="notifications-panel-container">{{{notificationsPanel}}}</div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{translate 'Leila Dashboard' scope='Admin'}}</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="well text-center">
                                <h3>{{translate 'Welcome to Leila' scope='Admin'}}</h3>
                                <p>{{translate 'Your AI-powered home service management platform' scope='Admin'}}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="well">
                                <h4>{{translate 'Quick Stats' scope='Admin'}}</h4>
                                <ul class="list-unstyled">
                                    <li>{{translate 'Version' scope='Admin'}}: {{version}}</li>
                                    <li>{{translate 'Last Update' scope='Admin'}}: {{lastUpdate}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="well">
                                <h4>{{translate 'Getting Started' scope='Admin'}}</h4>
                                <p>{{translate 'Configure your services, set up your team, and start managing bookings with AI assistance.' scope='Admin'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
