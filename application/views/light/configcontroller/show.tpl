<div class="container mt-3">
    <div class="container">
        <div id='actionok' class="actionok alert alert-success" role="alert">
            <strong>Dane zapisane poprawnie</strong>
        </div>
        <div id='actionerror' class="actionerror alert alert-danger" role="alert">
            <strong>Błąd zapisu danych.</strong>
        </div>
    </div>
    <div class="row container">
        <table class='table table-sm bok-two-column-layout'>
            <tr>
                <th>
                    Stawka kilometrowa
                </th>
                <td>
                    <input class="form-control form-control-md" type="text" id='txtStawkaKilometrowa'
                           value="{$configuration[0].stawka_kilometrowa|escape:'htmlall'}" autofocus/>
                </td>
            </tr>
            <tr>
                <th>
                    Stawka godzinowa
                </th>
                <td>
                    <input id="txtStawkaGodzinowa"
                           class="form-control form-control-md" type="text"
                           value="{$configuration[0].stawka_godzinowa|escape:'htmlall'}"
                    />
                </td>
            </tr>
            <tr>
                <th>
                   Wyszyść monitoring płatności
                </th>
                <td>
                    <a href="#" class="btn btn-outline-light active" role="button" aria-pressed="true"
                       onmousedown='clearPaymentMonitoring();return false;'><i class="fas fa-user-slash"></i>&nbsp; wyczyść</a>
                </td>
            </tr>
        </table>
    </div>

    <div class="container text-right">
        <a href="#" class="btn btn-outline-success active" role="button" aria-pressed="true"
           onmousedown='saveConfiguration();return false;'><i class="fas fa-save"></i>&nbsp; Zapisz</a>
        <a href="#" class="btn btn-outline-secondary" role="button" onclick="$.colorbox.close();">Anuluj</a>
    </div>
</div>