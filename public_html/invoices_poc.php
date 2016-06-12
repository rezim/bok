<html>
<head>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous">
    </script>

    <script>
        var json_params = {
            "api_token": "W9wbKMBuItznJvnIV10r/tregimowicz",
            "invoice": {
                "kind":"vat",
                "number": 1253,
                "seller_name": "Regimosoft Tomasz Regimowicz",
                "sell_date": "2016-05-25",
                "issue_date": "2016-05-25",
                "payment_to": "2016-06-01",
                "buyer_name": "Client1 SA",
                "buyer_tax_no": "5252445767",
                "positions":[
                    {"name":"Produkt A1", "tax":23, "total_price_gross":10.23, "quantity":1},
                    {"name":"Produkt A2", "tax":0, "total_price_gross":50, "quantity":2}
                ]
            }};
        //alert(JSON.stringify(json_params))
        endpoint = 'https://tregimowicz.fakturownia.pl/invoices.json';

        function add_invoice() {

            $.ajax({
                type: "POST",
                url: endpoint,
                data: json_params,
                dataType: 'json',
                success: function (data) {
                    alert('invoice created! ' + data['number'])
                }
            });
        }
    </script>
</head>
<body>
    <button onClick="add_invoice()" value="Dodaj Fakturę">Dodaj Fakturę</button>
</body>
</html>