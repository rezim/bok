<?php

include 'config/config.php';
include 'application/utils/mailTemplates.php';
include 'application/utils/mailing.php';
include 'application/utils/Email_reader.php';
include 'library/interestnotestrait.class.php';
include 'library/paymentstrait.class.php';
include 'library/externalclientstrait.class.php';
include 'library/controller.class.php';
include 'library/invoicescontroller.class.php';
include 'library/sqlquery.class.php';
include 'library/model.class.php';
include 'library/template.class.php';
include 'application/models/clientpayment.php';
include 'application/controllers/clientpaymentscontroller.php';
include 'application/utils/ProcessClientPayments.php';

//importClientPaymentsFromEmailBox();
processClientPayments('tregimowicz@gmail.com');






