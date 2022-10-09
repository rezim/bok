<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">

                <h3 class="modal-title" id="modal-title">
                    {{$data.description.title}}
                </h3>
                <div>{{$data.description.subtitle}}</div>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="messageDataContainer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label for="date" class="control-label">Data</label>
                                <div>
                                    <input type="text" class="form-control" id="date" name="date"
                                           placeholder="data wiadomości" data-ref>
                                </div>
                            </div>
                            <div class="form-group col-sm-9">
                                <label for="description" class="control-label">Treść:</label>
                                <div>
                    <textarea rows=4 type="text" class="form-control" id="message" name="message"
                              placeholder="treść wiadomości" data-ref data-clear-ref></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button class="btn btn-info" type="button" onclick="saveUpdateMessage('messageDataContainer', 'messageslist', '{{$data.type}}', '{{$data.foreignkey}}')">zapisz</button></div>
                        </div>
                        <input type="hidden" id="type" value="{{$data.type}}" data-ref>
                        <input type="hidden" id="foreignkey" value="{{$data.foreignkey}}" data-ref>
                    </div>
                </form>

                <form id="messageslist" class="form-horizontal" role="form">
                    {* Message Data Here *}
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    showMessages('messageslist', {{$data.type}}, '{{$data.foreignkey}}');
    $( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
    $( "#date" ).datepicker('setDate', 'today');
</script>