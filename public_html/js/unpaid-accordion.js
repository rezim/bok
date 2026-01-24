(function () {
    function closeAll(exceptClientId) {
        document.querySelectorAll(".js-acc-body").forEach((row) => {
            const id = row.getAttribute("data-client-id");
            if (!exceptClientId || id !== exceptClientId) {
                row.style.display = "none";
            }
        });
    }
    function getStickyTopOffset() {
        const candidates = [
            document.querySelector(".otus-navbar"),
        ].filter(Boolean);

        const h = candidates.length ? candidates[0].getBoundingClientRect().height : 0;

        // + small margin on top
        return Math.ceil(h) + 6;
    }

    const clientChannel = new BroadcastChannel("client-channel");
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".js-acc-toggle");
        if (!btn) return;

        e.preventDefault();

        const clientId = btn.getAttribute("data-client-id");
        if (!clientId) return;

        const safeClientId = CSS.escape(clientId);

        const header = document.querySelector(`.js-acc-header[data-client-id="${safeClientId}"]`);
        const body = document.querySelector(`.js-acc-body[data-client-id="${safeClientId}"]`);
        if (!body) return;

        const isOpen = body.style.display !== "none";

        closeAll(isOpen ? null : clientId);
        body.style.display = isOpen ? "none" : "";


        // ✅ Broadcast ONLY when opening the invoices view
        if (!isOpen) {
            // Prefer NIP from button; fallback to header if needed
            const nip =
                btn.getAttribute("data-client-nip") ||
                header?.getAttribute("data-client-nip");

            if (nip) {
                clientChannel.postMessage({
                    type: "CLIENT_INVOICES_OPENED",
                    nip: nip.trim(),
                    clientId
                });
            }
        }

        // Scroll only when opening
        if (!isOpen && header) {
            const OFFSET = getStickyTopOffset();

            // wait for DOM to recalculate after open/close other sections
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    const top = header.getBoundingClientRect().top + window.pageYOffset - OFFSET;
                    window.scrollTo({ top, behavior: "smooth" });
                });
            });
        }
    });
})();
