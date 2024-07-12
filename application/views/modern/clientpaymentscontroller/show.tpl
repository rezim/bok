<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit"
                            onClick="callServiceAction('/clientpayments/getpaymentsbyclients/notemplate', null, null, null);return false;">
                    Pobież płatności klienta
                    </button>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit"
                            onClick="callServiceAction('/clientpayments/addClientsPayments/notemplate', null, null, null);return false;">
                        Dodaj płatności
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">

        </main>
    </div>
</div>

<script type="text/javascript">
    showClientPayments('');
</script>