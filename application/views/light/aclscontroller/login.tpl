<div id='acl_OkienkoContainer'>
    <div class="card border-secondary">
        <div class="card-header">
            <img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0'
                 height='41'
                 width='75'
                 style='position:relative;margin-left: 0px;'
            />
        </div>
        <div class="card-body">
            <form>
                <div class="form-group row">
                    <label for="txtLogin" class="col-sm-3 col-form-label text-right">login</label>
                    <div class="col-sm-6">
                        <input class="form-control" id="txtLogin" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="txtPassword" class="col-sm-3 col-form-label text-right">hasło</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="txtPassword">
                    </div>
                </div>
                <div class="form-group row text-right">
                    <div class="col-sm-9">
                        <button onclick="acl_logowanie('{$smarty.const.SCIEZKA}','{$smarty.const.SCIEZKA}');return false;"
                                type="submit" class="btn btn-info"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;&nbsp;Zaloguj się</button>
                    </div>

                </div>
                <div id='actionerror' class="form-group row text-center aclmessage">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-9">
                        <div class="alert alert-danger" role="alert">
                            Podane konto i/lub hasło są niepoprawne.
                        </div>
                    </div>
                </div>

            </form>

            <p class="card-text"><small class="text-muted">Istniejemy dzięki naszym klientom!</small></p>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#txtLogin').unbind("keypress");
    $('#txtLogin').keypress(function (event) {
        if (event.keyCode == 13) {
            acl_logowanie('{$smarty.const.SCIEZKA}', '{$smarty.const.SCIEZKA}');
            return false;
        }
    });
    $('#txtPassword').unbind("keypress");
    $('#txtPassword').keypress(function (event) {
        if (event.keyCode == 13) {
            acl_logowanie('{$smarty.const.SCIEZKA}', '{$smarty.const.SCIEZKA}');
            return false;
        }
    });
</script>
