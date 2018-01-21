<!doctype html><?php /* ner app */ ?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>NBU Exchange Rates</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container">

    <div class="row">

        <div class="logo-img">
            <a href="/">
                <img class="logo img-thumbnail img-responsive" src="/img/whale-trans-64x64.png" alt="">
            </a>
        </div>

        <div class="buttons">
            <div class="mt-10 mb-5">
                <div class="form-inline">
                    <div class="form-group form-group-sm m-0">
                        <span class="ml-15">Курс НБУ валюты</span>
                        <div class="input-group ml-15">
                            <select class="form-control code-select" name="code" id="code" title="">
                                <option value="USD" data-r="840" selected>USD</option>
                                <option value="EUR" data-r="978">EUR</option>
                                <option value="RUB" data-r="643">RUB</option>
                                <option class="delimiter" disabled="">---------------</option>
                                @foreach($codes as $code)
                                    @if(!in_array($code->r030, [255, 840, 978, 643]))
                                        <option value="{{$code->cc}}" data-r="{{$code->r030}}">{{$code->cc}}</option>
                                    @endif
                                @endforeach
                                <option class="delimiter" disabled="">---------------</option>
                                <option value="0">Все валюты</option>
                            </select>
                        </div>
                        <span class="ml-15">на дату</span>
                        <div class="input-group ml-15">
                            <input class="form-control" type="date" id="date" value="{{ $today }}" title=""
                                   max="{{ $today }}">
                        </div>
                        <div class="input-group ml-15">
                            <button type="button" class="btn btn-sm btn-primary mb-5 get-button">
                                Получить курс
                            </button>
                        </div>

                        <span id="blink" class="alert alert-info hdn">Получение данных</span>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <table class="table table-bordered output-table">
                <thead>
                <tr>
                    <th>Код цифровой</th>
                    <th>Код литерный</th>
                    <th>Название валюты
                        <small>(укр.)</small>
                    </th>
                    <th>Официальный курс</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td colspan="100"></td>
                </tr>
                </tbody>

            </table>

        </div>

    </div>

</div>

<?php // <!-- Yandex.Metrika counter, JSUnresolvedFunction --> ?>
<?php if (0) { ?>
<!--suppress JSUnresolvedVariable, JSUnresolvedFunction -->
<?php } ?>
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter47223240 = new Ya.Metrika({
                    id: 47223240,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true,
                    ut: "noindex"
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera === "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/47223240?ut=noindex" style="position:absolute; left:-9999px;" alt=""/>
    </div>
</noscript>
<?php // <!-- /Yandex.Metrika counter --> ?>

<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/script.js"></script>
</body>
</html>
