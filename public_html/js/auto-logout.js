function autoLogout(warningTimeoutInMinutes, logoutUrl) {
    const warningTimeoutInSeconds = warningTimeoutInMinutes * 60;
    const timoutNowInSeconds = 59;

    if (warningTimeoutInSeconds <= timoutNowInSeconds) {
        return;
    }

    let warningTimerID, timeoutTimerID;
    let countDownTimer, countDownCounter;
    let blockResetTimer = false;

    const startTimer = () => {
        warningTimerID = window.setTimeout(warningInactive, (warningTimeoutInSeconds - timoutNowInSeconds) * 1000);
    };
    const warningInactive = () => {
        const toMMSSFormat = (seconds) => new Date(seconds * 1000).toISOString().slice(14, 19);
        window.clearTimeout(warningTimerID);
        timeoutTimerID = window.setTimeout(IdleTimeout, timoutNowInSeconds * 1000);
        countDownCounter = timoutNowInSeconds;

        // close all open modals
        $(".modal.show").modal('hide');
        // close colorbox if open
        if (closeColorbox) {
            closeColorbox();
        }

        $("#autoLogout #countDown").html(toMMSSFormat(countDownCounter));
        $('#autoLogout').modal('show');
        countDownTimer = setInterval(() => {
            $("#autoLogout #countDown").html(toMMSSFormat(--countDownCounter));
        }, 1000);

        blockResetTimer = true;
    };
    const resetTimer = () => {
        if (!blockResetTimer) {
            window.clearTimeout(timeoutTimerID);
            window.clearTimeout(warningTimerID);
            clearInterval(countDownTimer);
            startTimer();
        }
    };
    const IdleTimeout = () => {
        window.location = logoutUrl;
    };
    const setupTimers = () => {
        document.addEventListener("mousemove", resetTimer, false);
        document.addEventListener("mousedown", resetTimer, false);
        document.addEventListener("keypress", resetTimer, false);
        document.addEventListener("touchmove", resetTimer, false);
        document.addEventListener("onscroll", resetTimer, false);
        startTimer();
    };
    $(document).on('click', '#autoLogout button.btn', function () {
        blockResetTimer = false;
        resetTimer();
        $('#autoLogout').modal('hide');
    });
    $(document).ready(function () {

        $('body').append(
            '<div id="autoLogout" class="modal fade" style="z-index: 9999" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">' +
            '<div class="modal-dialog modal-dialog-centered" role="document">' +
            '<div class="modal-content">' +

            '<div class="modal-header card-header">' +
            '<h5 class="modal-title font-weight-bold">Koniec sesji</h5>' +
            '</div>' +
            '<div class="modal-body">' +
            '<p>Twoja sesja zbliża się do końca</p>' +
            '<p>Pozostało <span id="countDown" class="text-danger"></span><span class="text-danger">s</span></p>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-warning text-white">Przedłuż sesję&nbsp;<i class="fas fa-sign-in-alt"></i></button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>');

        setupTimers();
    });
}