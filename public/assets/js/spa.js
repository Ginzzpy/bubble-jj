$(document).ready(function () {
    // Remove partial tags
    function removePartialTags() {
        $('style[data-partial="true"], script[data-partial="true"]').remove();
    }

    // Loader helper
    function loader(status) {
        $("html").attr("loader", status ? "enable" : "disable");
    }

    // Link click handler
    function setActiveLink(url) {
        $(".spa-link").removeClass("active");
        $(".spa-link").each(function () {
            const href = $(this).attr("href");
            if (url === href) {
                $(this).addClass("active");
            }
        });
    }

    // Load page content
    function loadPage(url) {
        loader(true);

        $.get(url, function (response, textStatus, jqXHR) {
            const contentType = jqXHR.getResponseHeader("Content-Type") || "";

            if (!contentType.includes("application/json")) {
                $("#main-content").html(response);
                loader(false);
                return;
            }

            removePartialTags();

            const content = $("<div>").html(response.content);

            content.find('style[data-partial="true"]').each(function () {
                $("head").append(this);
            });
            content.find('script[data-partial="true"]').each(function () {
                $("body").append(this);
            });

            $("#main-content").html(content.html());

            if (response.title) {
                document.title = response.title;
                $("#breadcrumb").text(response.title);
            }

            setActiveLink(url);

            loader(false);
        }).fail(function () {
            $("#main-content").html(
                '<h4 class="text-danger">Gagal memuat halaman.</h4>'
            );
            loader(false);
        });
    }

    // SPA click handler
    $(document).on("click", ".spa-link", function (e) {
        const url = $(this).attr("href");
        if (!url || url === "#") return;

        e.preventDefault();
        loadPage(url);
        history.pushState(null, null, url);
    });

    // Browser back/forward
    window.onpopstate = function () {
        loadPage(location.pathname);
    };
});
