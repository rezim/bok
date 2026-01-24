<div class="container-fluid position-relative">
    {include file="$templates/partials/filters/deptors.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>
<script type="text/javascript">
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';
    const actionButtonId = 'applyFilter';

    const initDuplicateInvoiceListener = () => {
        // zabezpieczenie przed wielokrotnym podpięciem
        if (document.__duplicateInvoiceListenerAttached) {
            return;
        }
        document.__duplicateInvoiceListenerAttached = true;

        document.addEventListener('click', function (e) {
            const link = e.target.closest('.duplicate-invoice');
            if (!link) return;

            e.preventDefault();

            const today = new Date().toISOString().slice(0, 10);

            const duplicateDate = prompt(
                'Podaj datę duplikatu (YYYY-MM-DD):',
                today
            );

            if (!duplicateDate) return;

            const url =
                link.dataset.url +
                '&duplicate_date=' +
                encodeURIComponent(duplicateDate);

            window.open(url, '_blank');
        });
    };

    const initAccordionHeaderListener = () => {
        if (document.__accordionHeaderListenerAttached) {
            return;
        }
        document.__accordionHeaderListenerAttached = true;

        $("#tableDeptors").tablesorter({
            textExtraction: function (node) {
                const v = $(node).attr('data-value');
                return v != null ? v : $(node).text();
            }
        });

        $(document).on('click', '.js-acc-header', function (e) {


            // // Prevent double trigger when clicking on toggle icon or links
            // if ($(e.target).closest('.js-acc-toggle, a').length) return;
            //
            // const clientId = $(this).data('client-id');
            //
            // const $headerRow = $('.js-acc-header[data-client-id="' + clientId + '"]');
            // const $bodyRow   = $('.js-acc-body[data-client-id="' + clientId + '"]');
            //
            // const isVisible = $bodyRow.is(':visible');
            //
            // // Trigger the actual toggle (single source of truth)
            // $headerRow
            //     .find('.js-acc-toggle[data-client-id="' + clientId + '"]')
            //     .trigger('click');
            //
            // // Scroll only when expanding
            // if (!isVisible) {
            //
            //     alert('visible')
            //     // Delay to wait for slideToggle animation to start
            //     setTimeout(function () {
            //         const OFFSET = 10; // adjust if you have a sticky header
            //
            //         $('html, body').animate(
            //             {
            //                 scrollTop: $headerRow.offset().top - OFFSET
            //             },
            //             300
            //         );
            //     }, 220); // slightly more than slideToggle(200)
            // } else {
            //     alert('not visible')
            // }
        });
    };

    const fnRenderTemplate = async () => {
        const doneCallback = () => {

            initDuplicateInvoiceListener();
            // initAccordionHeaderListener();

        };
        renderTemplateAction("/clientinvoices/deptorsdata/todiv", dataContainerId, templateId, null, doneCallback);
    };

    // on enter press (any input in the form)
    $('#' + dataContainerId + ' input').unbind("keypress").keypress((event) => {
        if (event.keyCode === 13) {
            event.preventDefault();
            fnRenderTemplate();
        }
    });

    // on filter button click
    $('#' + actionButtonId).on('click', fnRenderTemplate);

    // first render
    fnRenderTemplate();
</script>