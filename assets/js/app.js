$( document ).ready(function() {
    var headerVideolinkDiv = $('.headerVideoLink');
    if(headerVideolinkDiv.length != 0) {
        headerVideolinkDiv.magnificPopup({
            type:'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        })
    }
}).on('click', '.headerVideoLink', function() {
    var headerVideolinkDiv = $('.headerVideoLink');
    if($(this).length != 0) {
        var subscriberId = $(this).attr('data-subscriberId');
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            dataType: "json",
            data: {
                subscriberId: subscriberId
            },
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            cache: false,
            success: function (data) {
                if (!data['success']) {
                    setTimeout(function() {
                        location.href = data['redirect'];
                    },3000);
                } else {
                    setTimeout(function() {
                        headerVideolinkDiv.magnificPopup({
                            type:'inline',
                            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
                        })
                        $.LoadingOverlay("hide");
                    },3000);
                }
            },error: function (err) {
                console.log(err);
            }
        });
    }
});

var quiz = $('#quiz');
if (quiz.length !=0 ) {
    fetch(myLabel.fetchQuizData)
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
           // console.log(data);
        $('#quiz').quiz({
            //resultsScreen: '#results-screen',
            counter: true,
            //homeButton: '#custom-home',
            counterFormat: 'Question %current of %total',
            questions: data,
            backUrl: myLabel.baseUrl,
            answerCallback: function (currentQuestion, selected, question) {
                $.ajax({
                    type: "POST",
                    url: myLabel.userGivenAnswer,
                    dataType: "json",
                    data: {
                        question: question.id,
                        answer: question.answerId,
                    },
                    cache: false,
                    success: function (data) {

                    },error: function (err) {
                        console.log(err);
                    }
                });
            },
            finishCallback: function (score, numQuestions) {
                $.ajax({
                    type: "POST",
                    url: myLabel.finishCallback,
                    dataType: "json",
                    data: {
                        quiz: myLabel.quizName,
                        score: score,
                        numQuestions: numQuestions,
                    },
                    cache: false,
                    success: function (data) {

                    },error: function (err) {
                        console.log(err);
                    }
                });
            }
        });
    })
}

    //$quiz.quiz({});


function download(filename) {
    if (typeof filename==='undefined') filename = ""; // default
    value = document.getElementById('textarea_area').value;

    filetype="text/*";
    extension=filename.substring(filename.lastIndexOf("."));
    for (var i = 0; i < extToMIME.length; i++) {
        if (extToMIME[i][0].localeCompare(extension)==0) {
            filetype=extToMIME[i][1];
            break;
        }
    }


    var pom = document.createElement('a');
    pom.setAttribute('href', 'data: '+filetype+';charset=utf-8,' + '\ufeff' + encodeURIComponent(value)); // Added BOM too
    pom.setAttribute('download', filename);


    if (document.createEvent) {
        if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) { // IE
            blobObject = new Blob(['\ufeff'+value]);
            window.navigator.msSaveBlob(blobObject, filename);
        } else { // FF, Chrome
            var event = document.createEvent('MouseEvents');
            event.initEvent('click', true, true);
            pom.dispatchEvent(event);
        }
    } else if( document.createEventObject ) { // Have No Idea
        var evObj = document.createEventObject();
        pom.fireEvent( 'onclick' , evObj );
    } else { // For Any Case
        pom.click();
    }

}
function downloadURL(url) {
    var hiddenIFrameID = 'hiddenDownloader',
        iframe = document.getElementById(hiddenIFrameID);
    if (iframe === null) {
        iframe = document.createElement('iframe');
        iframe.id = hiddenIFrameID;
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
    }
    iframe.src = url;
};

var map = $('#map');
var paths = $('.map__image a');

if(map.length != 0) {
    if(NodeList.prototype.forEach == undefined) {
        NodeList.prototype.forEach = function (callback) {
            [].forEach().call(this, callback);
        }
    }
    // $("#map").mapify({
    //     popOver: {
    //         content: function(path){
    //             return "<strong>"+path.attr("xlink:title")+"</strong>";
    //         },
    //         delay: 0.7,
    //         margin: "15px",
    //         height: "130px",
    //         width: "260px"
    //     }
    // });
    //MAP TOOLTIPS SCRIPT
    //var tooltipNum = ['#nova-scotia', '#new-brunswick']

    $(paths).qtip({
        content: function() {
            return $( this ).data('tooltip'); //store data in data-tooltip
        },
        position: {
            my: 'bottom center',  // Position my top left...
            at: 'top center', // at the bottom right of...
            adjust: {
                y: 10
            }
        },
        style: {
            tip: {
                corner: true,
                corner: 'bottom center',
                border: 1,
                width: 15,
                height: 7
            }
        }
    });
    paths.each(function (path) {

        $(this).on("click", function(){
            var countryIso      = $(this).attr('data-iso');
            var subscriberId    = $(this).attr('data-subscriberid');

            var formData = new FormData();
            formData.append('userId', subscriberId);
            formData.append('countryIso', countryIso);

            $.ajax({
                type: "POST",
                url: $(this).attr('data-url'),
                dataType: "json",
                data: {
                    subscriberId: subscriberId
                },
                beforeSend: function() {
                    $.LoadingOverlay("show");
                },
                cache: false,
                success: function (res) {
                    if (res['success']) {
                        stampToPassport({data: formData});

                    } else {
                        setTimeout(function() {
                            location.href = myLabel.viewplans;
                        },3000);
                    }
                },error: function (err) {
                    console.log(err);
                }
            });

            function stampToPassport(options) {
                fetch(myLabel.stampToPassport, {
                    method: 'post',
                    body: options.data
                }).then(function(response) {
                    return response.json();
                }).then(function (data) {
                    var success = data.success;
                    if(success) {
                        console.log(success);
                        setTimeout(function() {
                            location.href = data.redirect;
                        },3000);
                    } else {
                        setTimeout(function() {
                            location.href = data.redirect;
                        },3000);
                    }

                });
            }
        });
    })




}
$(document).ready(function(){
    $('#imageGallery').lightGallery();
    $('#videoGallery').lightGallery();
    $('.activityBooks').lightGallery();
});



