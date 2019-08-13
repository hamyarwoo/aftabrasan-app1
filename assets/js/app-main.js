const vapidPublicKey = 'BBnpssqQeDV4toU2tDlc9taOX_MgTriCHJ5TP-Hn7Fg5CngjWHrT6M4_HQXprFl97CqmaLqYrMR1Kc-f4JuhNK0';
webpush = window.WebPushLib;
// const webpush = require("web-push");
// import { webpush } from "web-push";
// import "./web-push";
/** jquery validator */
if (typeof jQuery.validator === "function") {
    jQuery.validator.addMethod("nationalId", function (value, element, input) {
        if (value.length == 0)
            return true;
        return Services.checkNationalId(value);
    });
    jQuery.validator.addMethod("irMobile", function (value, element) {
        return this.optional(element) || /^(\+98|0)?9\d{9}$/.test(value);
    });
    jQuery.validator.addMethod("irTel", function (value, element) {
        return this.optional(element) || /^(\0)?[0-9]{2}\d{9}$/.test(value);
    });
    jQuery.validator.addMethod("minPrice", function (value, element, input) {
        const price = Services.removeCommaString(value);
        return (price < input) ? false : true;
    });
    jQuery.validator.addMethod("maxPrice", function (value, element, input) {
        const price = Services.removeCommaString(value);
        return (price > input) ? false : true;
    });
    jQuery.validator.addMethod("checkPassword", function (password, element) {
        if (password.length > 0) {
            if (password.length >= 8) {
                const pat1 = /[a-zA-Z]/;
                if (pat1.test(password)) {
                    const pat2 = /[0-9]/;
                    return pat2.test(password);
                }
            }
            return false;
        }
        return true;
    });
    jQuery.extend(jQuery.validator.messages, {
        required: "وارد کردن فیلد الزامی است",
        remote: "لطفا این فیلد را اصلاح کنید",
        email: "لطفا یک آدرس ایمیل معتبر وارد کنید.",
        url: "لطفا یک نشانی معتبر وارد کنید",
        date: "لطفا یک تاریخ معتبر وارد کنید.",
        dateISO: "لطفا یک تاریخ معتبر (ISO) را وارد کنید.",
        number: "لطفا یک شماره معتبر وارد کنید.",
        digits: "لطفا فقط رقم را وارد کنید",
        creditcard: "لطفا یک شماره کارت اعتباری معتبر وارد کنید.",
        equalTo: "لطفا مجددا همان مقدار را وارد کنید.",
        accept: "لطفا یک مقدار با یک پسوند معتبر وارد کنید",
        maxlength: jQuery.validator.format("لطفا حداکثر {0} نویسه را وارد کنید"),
        minlength: jQuery.validator.format("لطفا حداقل {0} نویسه را وارد کنید"),
        rangelength: jQuery.validator.format("لطفا یک مقدار بین {0} و {1} حرف طولانی وارد کنید"),
        range: jQuery.validator.format("لطفا یک مقدار بین {0} و {1} را وارد کنید."),
        max: jQuery.validator.format("لطفا یک مقدار کمتر یا برابر {0} را وارد کنید."),
        min: jQuery.validator.format("لطفا یک مقدار بزرگتر یا برابر {0} را وارد کنید."),
        irMobile: "شماره تلفن همراه را به صورت صحیح وارد کنید",
        irTel: "شماره تلفن ثابت را به صورت صحیح وارد کنید",
        minPrice: jQuery.validator.format("لطفا یک مقدار بزرگتر یا برابر {0} را وارد کنید."),
        maxPrice: jQuery.validator.format("لطفا یک مقدار کمتر یا برابر {0} را وارد کنید."),
        nationalId: 'کد ملی را به صورت صحیح وارد کنید',
        checkPassword: 'رمز عبور باید شامل اعداد و حروف و حداقل 8 کاراکتر باشد',
    });

    jQuery.validator.setDefaults({
        errorElement: 'span',
        errorClass: "invalid-tooltip",
        highlight: function (element, errorClass, validClass) {
            parent_in_group = $(element).parents('.input-group');
            if (parent_in_group.length > 0) {
                parent_in_group.addClass('has-error');
            } else {
                if ($(element).hasClass("select2")) {
                    $(element).parents('.form-group').find('.select2-selection--single').addClass('has-error');
                    ;
                } else {
                    $(element).parents('div.form-group').addClass('has-error');
                }

            }
        },
        unhighlight: function (element, errorClass, validClass) {
            parent_in_group = $(element).parents('.input-group');
            if (parent_in_group.length > 0) {
                parent_in_group.removeClass('has-error');
            } else {
                if ($(element).hasClass("select2")) {
                    $(element).parents('.form-group').find('.select2-selection--single').removeClass('has-error');
                    ;
                } else {
                    $(element).parents('div.form-group').removeClass('has-error');
                }
            }
        },
        errorPlacement: function (error, element) {
            type = $(element).attr("type")
            error.addClass("invalid-feedback");
            parent_in_group = $(element).parents('.input-group');
            if (type == "radio") {
                error.insertAfter($(element).parents('.form-group'));
            } else if (type == 'checkbox') {
                error.insertAfter($(element).parents('.checkbox'));
            } else {
                if (parent_in_group.length > 0) {
                    error.insertAfter(parent_in_group);
                } else {
                    error.insertAfter(element);
                }
            }
        },
    });
}


$('.app_form button').on("click", function (e) {
    e.preventDefault();
    $("#frm-login").validate({
        rules: {
            mobile: {irMobile: true}
        },
    });
    var valid = $(".app_form").valid();


    if (valid == true) {
        $(this).find("i").hide();
        $(this).append('<i class="fa fa-spinner fa-spin"></i>');

        var form = $(this).parents("form");
        var formAction = form.attr("action");
        var method = form.attr("method");
        var data = form.serializeArray();

        handleAjax(formAction, method, data, function (data) {

            //success operation here
            msg = data.msg;
            if (data.token) {

                localStorage.setItem('token', data.token);
                document.location.href = site_url + 'dashboard';
            }

            setTimeout(function () {
                $('.ajax-alert').slideUp(300);
            }, 10000);

        }, function () {

            //error operation here
            $('.ajax-alert').removeClass("alert-success");
            $('.ajax-alert').addClass("alert");
            $('.ajax-alert').addClass("alert-danger");

            $('.ajax-alert').slideDown(300);
            setTimeout(function () {
                $('.ajax-alert').slideUp(300);
            }, 10000);

        });
    }
});

function closeAlertMSG(tag) {
    $(tag).parents(".alert").slideUp();
}

function handleAjax(formAction, method, data, success, error, next_url = null) {
    if (localStorage.getItem("token")) {
        $.ajax({
            url: formAction,
            method: method,
            dataType: 'json',
            data: data,
            headers: {
                'X-AUTH': localStorage.getItem("token"),
                'Accept': '*/*',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            success: function (data) {

                $('.submit_icon').show();
                success(data);
                $('.fa.fa-spinner.fa-spin').hide();
                if (next_url) {
                    document.location.href = next_url;
                }
                msg = data.msg;
                $('.ajax-alert .msg').html(msg);


            },
            error: function (data) {
                $('.submit_icon').show();
                $('.fa.fa-spinner.fa-spin').hide();
                if (data.responseJSON) {
                    var msg = data.responseJSON.msg[0];

                    $('.ajax-alert .msg').html(msg);
                } else {

                    $('.ajax-alert .msg').html("\"پاسخی دریافت نشد ، وضعیت اینترنت خود را چک بفرمایید\"");
                }
                error();
            }
        });
    } else {

        $.ajax({
            url: formAction,
            method: method,
            dataType: 'json',
            data: data,
            headers: {},
            success: function (data) {

                $('.submit_icon').show();
                success(data);
                $('.fa.fa-spinner.fa-spin').hide();
                if (next_url) {
                    document.location.href = next_url;
                }
                msg = data.msg;
                $('.ajax-alert .msg').html(msg);


            },
            error: function (data) {
                $('.submit_icon').show();
                $('.fa.fa-spinner.fa-spin').hide();
                if (data.responseJSON) {
                    var msg = data.responseJSON.msg[0];

                    $('.ajax-alert .msg').html(msg);
                } else {

                    $('.ajax-alert .msg').html("\"پاسخی دریافت نشد ، وضعیت اینترنت خود را چک بفرمایید\"");
                }
                error();
            }
        });

    }
}

function handleAjaxRequest(formAction, method, data, success, error, next_url = null) {
    if (localStorage.getItem("token")) {
        $.ajax({
            url: formAction,
            method: method,
            dataType: 'json',
            data: data,
            headers: {
                'X-AUTH': localStorage.getItem("token"),
                'Accept': '*/*',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            success: function (data) {

                $('.submit_icon').show();
                success(data);
                $('.fa.fa-spinner.fa-spin').hide();
                if (next_url) {
                    document.location.href = next_url;
                }
                msg = data.msg;
                $('.ajax-alert .msg').html(msg);
                $('.loading_back').fadeOut(200);

            },
            error: function (data) {


                if (data.status === 401) {
                    localStorage.removeItem("token");
                    alert(data.status);
                    //document.location.href = site_url+'login';
                }
                $('.submit_icon').show();
                $('.fa.fa-spinner.fa-spin').hide();
                console.log(data);
                if (data.responseJSON) {

                    var msg = data.responseJSON.msg[0];
                    $('.ajax-alert .msg').html(msg);

                } else {

                    $('.ajax-alert .msg').html("\"پاسخی دریافت نشد ، وضعیت اینترنت خود را چک بفرمایید\"");

                }
                error();

            }
        });
    } else {
        $.ajax({
            url: formAction,
            method: method,
            dataType: 'json',
            data: data,
            headers: {
                'Accept': '*/*',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            success: function (data) {

                $('.submit_icon').show();
                success(data);
                $('.fa.fa-spinner.fa-spin').hide();
                if (next_url) {
                    document.location.href = next_url;
                }
                msg = data.msg;
                $('.ajax-alert .msg').html(msg);
                $('.loading_back').fadeOut(200);

            },
            error: function (data) {


                if (data.status === 401) {
                    localStorage.removeItem("token");
                    document.location.href = site_url + 'login';
                }
                $('.submit_icon').show();
                $('.fa.fa-spinner.fa-spin').hide();
                if (data.responseJSON) {

                    var msg = data.responseJSON.msg[0];
                    $('.ajax-alert .msg').html(msg);

                } else {

                    $('.ajax-alert .msg').html("\"پاسخی دریافت نشد ، وضعیت اینترنت خود را چک بفرمایید\"");

                }
                error();

            }
        });
    }
}


function toggleMenu(tag, event) {
    $('.main_menu').toggleClass("open");
}


function closeMainMenu() {
    $('.main_menu').removeClass("open");
}


let swreg;
if ('Notification' in window && 'serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker

            .register('service-worker.js')
            .then(function (reg) {
                swreg = reg;
            })
            .catch(function (e) {
                console.error('SW Errors while registering!');
                console.log(e);
            });
    });
    // $('#notification').on("click", function (e) {
    //     e.preventDefault();
    //     Notification.requestPermission(function (userChoise) {
    //         if (userChoise ==="denied"){
    //             console.log(userChoise);
    //         } else{
    //
    //
    //             navigator.serviceWorker.ready.then(function (reg) {
    //                 reg.pushManager.getSubscription().then(function (then) {
    //                     console.log("THEN",then)
    //                 }).catch(function (e) {
    //                     console.log('e',e);
    //                 });
    //                 return reg.pushManager.getSubscription();
    //             }).then(function (pushSubscriptiob) {
    //                 console.log('pushSubscriptiob',pushSubscriptiob);
    //                 if (pushSubscriptiob){
    //                 console.log("has Already Subscription");
    //                 alert("شما قبلا سابسکرایب شده اید")
    //                 return;
    //                 }else{
    //                     const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);
    //                     swreg.pushManager.subscribe({
    //                         userVisibleOnly: true,
    //                         applicationServerKey: convertedVapidKey
    //                     }).then(function (newPostSubscription) {
    //                         console.log(newPostSubscription);
    //                         saveSubscription(newPostSubscription);
    //                         webpush.setVapidDetails(
    //                             'mailto:me@aftabrasan.com', "BBnpssqQeDV4toU2tDlc9taOX_MgTriCHJ5TP-Hn7Fg5CngjWHrT6M4_HQXprFl97CqmaLqYrMR1Kc-f4JuhNK0", "g2a6TM_oJgU9xSMRnLyQ1IkGpWegWT5sJxnh2ybypLI"
    //                         );
    //                     }).then(function () {
    //
    //                         setTimeout(function () {
    //                             $.ajax({
    //                                 url :site_url+'sub/get',
    //                                 method : "get",
    //                                 data:{},
    //                                 success:function (msg) {
    //
    //
    //                                     $.each(msg,function (index,val) {
    //
    //                                         const pushSubscription = {
    //                                             endpoint: val.endpoint,
    //                                             keys: {
    //                                                 auth: val.auth,
    //                                                 p256dh: val.p256dh
    //                                             }
    //                                         };
    //                                         console.log(pushSubscription);
    //                                         webpush.sendNotification(pushSubscription, "TEST").catch(function (e) {
    //                                             console.log(e);
    //                                         });
    //                                     })
    //                                 }
    //                             });
    //                         },3000);
    //
    //                     });
    //
    //
    //
    //
    //                     // new Notification('Subscribe Graunted',options);
    //
    //                 }
    //             });
    //
    //
    //         }
    //     })
    // })

    $(document).on('click touchend', '#notification', function (e) {

        e.preventDefault();
        Notification.requestPermission(function (userChoise) {
            if (userChoise === "denied") {
                console.log(userChoise);
            } else {


                navigator.serviceWorker.ready.then(function (reg) {
                    reg.pushManager.getSubscription().then(function (then) {
                        console.log("THEN", then)
                    }).catch(function (e) {
                        console.log('e', e);
                    });
                    return reg.pushManager.getSubscription();
                }).then(function (pushSubscriptiob) {
                    console.log('pushSubscriptiob', pushSubscriptiob);
                    if (pushSubscriptiob) {
                        console.log("has Already Subscription");
                        alert("شما قبلا سابسکرایب شده اید")
                        return;
                    } else {
                        const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);
                        swreg.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: convertedVapidKey
                        }).then(function (newPostSubscription) {
                            console.log(newPostSubscription);
                            saveSubscription(newPostSubscription);
                            webpush.setVapidDetails(
                                'mailto:me@aftabrasan.com', "BBnpssqQeDV4toU2tDlc9taOX_MgTriCHJ5TP-Hn7Fg5CngjWHrT6M4_HQXprFl97CqmaLqYrMR1Kc-f4JuhNK0", "g2a6TM_oJgU9xSMRnLyQ1IkGpWegWT5sJxnh2ybypLI"
                            );
                        }).then(function () {

                            setTimeout(function () {
                                $.ajax({
                                    url: site_url + 'sub/get',
                                    method: "get",
                                    data: {},
                                    success: function (msg) {


                                        $.each(msg, function (index, val) {

                                            const pushSubscription = {
                                                endpoint: val.endpoint,
                                                keys: {
                                                    auth: val.auth,
                                                    p256dh: val.p256dh
                                                }
                                            };
                                            console.log(pushSubscription);
                                            webpush.sendNotification(pushSubscription, "TEST").catch(function (e) {
                                                console.log(e);
                                            });
                                        })
                                    }
                                });
                            }, 3000);

                        });


                        // new Notification('Subscribe Graunted',options);

                    }
                });


            }
        })

        // Some code to be executed after #anyHTMLelement is Touched or clicked
    });
}

function showSuccessMessage(message) {
    var options = {
        body: 'You successfully Subscribed1111',
        icon: '../images/icon-96x96.png',
        image: '../images/image-sample.jpg',
        badge: '../images/icon-96x96.png',
        dir: 'ltr',
        vibrate: [100, 50, 200],
    };
    navigator.serviceWorker.ready.then(
        function (registration) {
            registration.showNotification(message,)
        }
    )
}

function saveSubscription(msg) {


    var data = window.btoa(JSON.stringify(msg));

    $.ajax({
        url: site_url + 'sub/save',
        method: "post",
        data: {data: data},
        success: function (msg) {

        },
        error: function (msg) {
            console.log(msg);
        }
    });
}

function getAllSubscription(msg) {


    $.ajax({
        url: site_url + '/sub/get',
        method: "get",
        data: {},
        success: function (msg) {
            return msg;
        }
    });
}


function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

$("#notification_send").click(function (e) {
    e.preventDefault();
    webpush.setVapidDetails(
        'mailto:me@aftabrasan.com', "BBnpssqQeDV4toU2tDlc9taOX_MgTriCHJ5TP-Hn7Fg5CngjWHrT6M4_HQXprFl97CqmaLqYrMR1Kc-f4JuhNK0", "g2a6TM_oJgU9xSMRnLyQ1IkGpWegWT5sJxnh2ybypLI"
    );
    if (confirm(" مطمعن هستید ؟ ")) {

        $.ajax({
            url: site_url + 'sub/get',
            method: "get",
            data: {},
            success: function (msg) {


                $.each(msg, function (index, val) {

                    const pushSubscription = {
                        endpoint: val.endpoint,
                        keys: {
                            auth: val.auth,
                            p256dh: val.p256dh
                        }
                    };
                    console.log(pushSubscription);
                    webpush.sendNotification(pushSubscription, "TEST").then(function () {
                        console.log("Ersal shod");
                    }).catch(function (error) {
                        if (error.statusCode === 410) {
                            $.ajax({
                                url: site_url + 'sub/delete',
                                method: "post",
                                data: {id: index},
                                success: function (msg) {

                                }
                            })
                        }
                    });
                })
            }
        });

    }
})


var defPromt;
$('.install_pwa').on("click", function () {

    if (defPromt) {
        defPromt.prompt();
        defPromt.userChoise.then(function (choise) {
            if (choise.outcome === "dismissed") {
                console.log("DISSSSMISSSED");
            } else {

            }
        })

    } else {

    }
})

window.addEventListener("beforeinstallprompt", function (event) {
    event.preventDefault();

    defPromt = event;
    return false;
})

