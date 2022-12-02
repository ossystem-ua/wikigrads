jQuery(document).ready(function() {
    tour.init();
    tour.restart();
jQuery()
});
jQuery(".landing_header_line").html(jQuery(".wiki_header_line-tour").html());
jQuery(".wiki_header_line").html(jQuery(".wiki_header_line-tour").html());
jQuery(".landing_header_line").css({"height": "50px"});
jQuery("#wiki-main-menu-course > li").css({"margin-right": "25px"});

var template  = "<div class='popover tour'>";
    template += "<div class='arrow'></div>";
    template += "<h3 class='popover-title'></h3>";
    template += "<div class='popover-content'></div>";
    template += "<div class='popover-navigation'>";
    template += "<div class='tour-line'></div>";
    template += "<a data-role='prev'><span class='tour-arrow-left'></span>Prev</a>";
    template += "<a data-role='next'>Next<span class='tour-arrow-right'></span></a>";
    template += "</div>";
    template += "</div>";

var template1  = "<div class='popover tour'>";
    template1 += "<div class='arrow'></div>";
    template1 += "<h3 class='popover-title'></h3>";
    template1 += "<div class='popover-content'></div>";
    template1 += "<div class='popover-navigation'>";
    template1 += "<div class='tour-line'></div>";
    template1 += "<a data-role='prev'><span class='tour-arrow-left'></span>Prev</a>";
    template1 += "<a class='' data-role='end'>End tour</a>";
    template1 += "</div>";
    template1 += "</div>";

var step2_1   = '<div id="step2-1" style="">Streamline communication<br/> in the Course Feed</div>',
    step3_1   = '<div id="step3-1">Streamline communication<br/> in the Course Feed</div>',
    step7A_1  = '<div id="step7A-1">Temporal continuity enhances<br/>clarity and immediacy</div>',
    step7A_2  = '<div id="step7A-2">Student and instructor names<br/>are color-coded blue and<br/> orange, respectively</div>',
    step8_1   = '<div id="step8-1"><div class="tour-orange-arrow"></div>Growing conversation<br/>remain linked to documents<br/>and images</div>';
    step9_1   = '<div id="step9-1">Become a facilitator of learning,<br/>and enjoyseeing students<br/>become active participants in<br/>the learning process</div>';
    step9_2   = '<div id="step9-2"><div class="tour-orange-arrow-two"></div>Link documents and images to<br/>comments</div>';
    step12_1  = '<div id="step12-1">Free your email inbox</div>';
    step13_1  = '<div id="step13-1">Enhance accessibility and<br/>invite student communication</div>';
    step14_1  = '<div id="step14-1">Easily scaffold assignments</div>';
    step14_2  = '<div id="step14-2">Temporal continuity enhances<br/>clarity and organization</div>';

var tour = new Tour({
  steps: [
  {
    path: "/tour",
    title: "<a class='' data-role='end'>End tour</a>",
    content: "<p>WikiGrads features two communications feeds, the Course Feed\n\
               and the Private Feed, which respectively facilitate:</p>\n\
                <ul><li>Many-to-many communication for the entire class</li>\n\
                <li>Student-instructor messenging and file sharing</li></ul>",
    backdrop: true,
    orphan: true,
    prev: -1,
    onShown: function (tour) {
        jQuery(".popover").css({"top": "70px"});
    }
  }, {
    path: "/tour",
    element: "#for-tour-step-2",
    placement: "right",
    title: "<a class='' data-role='end'>End tour</a>",
    content: "<p>Click here to contribute a<br/>document or image.</p>\n\
               <p>Type or copy & paste here</p>",
    onShow: function (tour) {
        jQuery("#step2-1").hide();
    },
    onShown: function (tour) {
        if(jQuery("#step2-1").length === 0) {
            jQuery("#step2").prepend(step2_1);
        }
        jQuery("#step2-1").fadeIn(500);
        jQuery(".popover .arrow").css({"top": "66px"});
        jQuery(".popover").prepend("<div class='tour-arrow-left-one'></div><div class='arrow-two'></div><div class='tour-arrow-left-two'></div>");
    },
    onPrev: function (tour) {
        jQuery("#step2-1").fadeOut(500).remove();
    },
    onNext: function (tour) {
        jQuery("#step2-1").fadeOut(500).remove();
    }
  }, {
    path: "/tour",
    element: "#tour-step3",
    placement: "right",
    title: "<a class='' data-role='end'>End tour</a>",
    content: "Filter Course Feed content<br/>by documents, images or<br/>links.",
    onShow: function (tour) {
        jQuery("#post-filter").attr("class", "open-filter");
        jQuery("#filter-block ul").css({"overflow": "hidden", "display": "block"});
    },
    onShown: function (tour) {
        if(jQuery("#step3-1").length === 0) {
            jQuery("#step2").prepend(step3_1);
        }
        jQuery("#step3-1").fadeIn(500);
        jQuery(".popover").prepend("<div class='tour-arrow-left-three'></div>");
    },
    onPrev: function (tour){
        jQuery("#step3-1").fadeOut(500).remove();
        jQuery("#post-filter").attr("class", "close-filter");
        jQuery("#filter-block ul").css({"display": "none"});
    },
    onNext: function (tour){
        jQuery("#step3-1").fadeOut(500).remove();
        jQuery("#post-filter").attr("class", "close-filter");
        jQuery("#filter-block ul").css({"display": "none"});
    }
  }, {
    path: "/tour",
    element: "#tour-step4",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "left",
    content: "WikiGrads auto-organizes<br/>all student communication<br/>and file sharing by course.",
    onShow: function (tour) {
        jQuery("#wiki-main-menu-course li:first-child a").attr("class", "tooltip collapsible active-main-menu expanded");
        jQuery("#wiki-main-menu-course li:first-child ul").css({"overflow": "hidden", "display": "block"});
    },
    onShown: function (tour) {
        if(jQuery("#step3-1").length === 0) {
            jQuery("#step2").prepend(step3_1);
        }
        jQuery("#step3-1").fadeIn(500);
        jQuery(".popover").css({"margin-left": "-20px"});
        jQuery(".popover").prepend("<div class='tour-arrow-right-one'></div>");
    },
    onPrev: function (tour){
        jQuery("#step3-1").fadeOut(500).remove();
        jQuery("#wiki-main-menu-course li:first-child a").attr("class", "tooltip collapsed collapsible");
        jQuery("#wiki-main-menu-course li:first-child ul").css({"display": "none"});
    },
    onNext: function (tour){
        jQuery("#step3-1").fadeOut(500).remove();
        jQuery("#wiki-main-menu-course li:first-child a").attr("class", "tooltip collapsed collapsible");
        jQuery("#wiki-main-menu-course li:first-child ul").css({"display": "none"});
    }
  }, {
    path: "/tour",
    element: "#post_is_pinned",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "left",
    content: "<a style='color: #f07d18; font-family: \"Lato-Bold\"; text-decoration: underline;'>Instructors only</a><br/>Pin an introductory post to<br/>your students at the top of<br/>the Course Feed.",
    onShown: function (tour) {
        jQuery("#post_is_pinned").attr("checked", "checked");
        var text = "Hi everyone! This is a place to celebrate our ignorance, imperfection, confusion and struggles. ";
            text += "Whenever possible, please ask your questions here on the Course Feed for everyone to read and comment. ";
            text += "QUESTIONS ARE POWERFUL CONTRIBUTIONS! They help everyone learn and us teach! ";
            text += "Remember that the Course Feed is for peer interaction and learning. ";
            text += "The TAs and I may not answer questions immediately because we expect you and your peers to engage before we do. ";
            text += "he platform is for you. Have fun with this!";
        jQuery("#post_content").val(text).css({"height": "100px"});
        jQuery(".popover").css({"top": "293px", "margin-left": "-15px"});
        jQuery(".popover .arrow").css({"top": "46px"});
        jQuery(".popover").prepend("<div class='tour-arrow-right-one'></div>");
    },
    onPrev: function (tour) {
        jQuery("#post_is_pinned").removeAttr("checked");
        jQuery("#post_content").val("Ask, discuss, blog...").css({"height": "30px"});
    },
    onNext: function (tour) {
        jQuery("#post_is_pinned").removeAttr("checked");
        jQuery("#post_content").val("Ask, discuss, blog...").css({"height": "30px"});
    }
  }, {
    path: "/tour",
    element: "#wiki-post-block-2916",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "top",
    content: "<a style='color: #f07d18; font-family: \"Lato-Bold\"; text-decoration: underline;'>Instructors only</a><br/>Pinned post",
    onShow: function (tour) {
        jQuery("#wiki-post-block-2916").fadeIn(500);
    },
    onShown: function (tour) {
        jQuery(".popover").prepend("<div class='tour-arrow-bottom-one'></div>");
    },
    onPrev: function (tour) {
        jQuery("#wiki-post-block-2916").fadeOut(500);
    }
  }, {
    path: "/tour",
    element: "#tour-step7",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "bottom",
    content: "Auto-collapsing conversa-<br/>tion enhance readability and organization",
    onShow: function (tour) {
        jQuery("#wiki-post-block-2916").fadeIn(500);
        jQuery("#wiki-post-block-5788").css({"margin-bottom": "200px"}).fadeIn(500);
    },
    onShown: function (tour) {
        jQuery(".popover").css({"margin-left": "155px"});
        jQuery(".popover").prepend("<div class='tour-arrow-top-one'></div>");
    },
    onPrev: function (tour) {
        jQuery("#wiki-post-block-5788").fadeOut(500);
    }
  }, {
    path: "/tour",
    element: "#tour-step7A",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "right",
    content: "<a style='color: #62cbcc; font-family: \"Lato-Bold\"\; text-decoration: underline;'>Student-driven interactions</a><br/>Students voluntarily help<br/>each other",
    onShow: function (tour) {
        jQuery("#wiki-post-block-2916").fadeIn(500);
        jQuery("#wiki-post-block-5788").css({"margin-bottom": "0px"}).fadeIn(500);
        jQuery("#wiki-comment-list-5788").fadeIn(500);
    },
    onShown: function (tour) {
        if(jQuery("#step7A-1").length === 0) {
            jQuery("#orange-block-step7A").prepend(step7A_1);
        }
        if(jQuery("#step7A-2").length === 0) {
            jQuery("#orange-block-step7B").prepend(step7A_2);
        }
        jQuery("#step7A-1").fadeIn(500);
        jQuery("#step7A-2").fadeIn(500);
        jQuery(".popover .arrow").css({"display": "none"});
    },
    onNext: function (tour) {
        jQuery("#step7A-1").fadeOut(500).remove();
        jQuery("#step7A-2").fadeOut(500).remove();
    },
    onPrev: function (tour) {
        jQuery("#wiki-comment-list-5788").fadeOut(500);
        jQuery("#step7A-1").fadeOut(500).remove();
        jQuery("#step7A-2").fadeOut(500).remove();
    }
  }, {
    path: "/tour",
    element: "#tour-step8",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "right",
    content: "Expose students to the work  of<br/>their peers. Socialize writing<br/> assingments",
    onShow: function (tour) {
        jQuery("#wiki-post-block-2916").fadeIn(500);
        jQuery("#wiki-post-block-5788").css({"margin-bottom": "0px"}).fadeIn(500);
        jQuery("#wiki-comment-list-5788").fadeIn(500);
        jQuery("#wiki-post-block-5785").fadeIn(500);
    },
    onShown: function (tour) {
        if(jQuery("#step8-1").length === 0) {
            jQuery("#orange-block-step8").prepend(step8_1);
        }
        jQuery("#step8-1").fadeIn(500);
        jQuery(".popover").css({"margin-top": "-125px"});
        jQuery(".popover .arrow").css({"display": "none"});
    },
    onNext: function (tour) {
        jQuery("#step8-1").fadeOut(500);
    },
    onPrev: function (tour) {
        jQuery("#wiki-comment-list-5785").fadeOut(500);
        jQuery("#step8-1").fadeOut(500);
    }
  }, {
    path: "/tour",
    element: "#tour-step9",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "left",
    content: "<a style='color: #f07d18; font-family: \"Lato-Bold\"; text-decoration: underline;'>Instructors only</a><br/>Instructor and TAs can edit or<br/>delete an post",
    onShow: function (tour) {
        jQuery("#wiki-post-block-2916").fadeIn(500);
        jQuery("#wiki-post-block-5788").css({"margin-bottom": "0px"}).fadeIn(500);
        jQuery("#wiki-comment-list-5788").fadeIn(500);
        jQuery("#wiki-post-block-5785").fadeIn(500);
        jQuery("#wiki-post-block-5781").css({"margin-bottom": "200px"}).fadeIn(500);
    },
    onShown: function (tour) {
        if(jQuery("#step9-1").length === 0) {
            jQuery("#orange-block-step9A").prepend(step9_1);
        }
        if(jQuery("#step9-2").length === 0) {
            jQuery("#orange-block-step9B").prepend(step9_2);
        }
        jQuery("#step9-1").fadeIn(500);
        jQuery("#step9-2").fadeIn(500);
        jQuery(".popover").css({"margin-top": "40px"});
        jQuery(".popover").prepend("<div class='tour-arrow-right-two'></div>");
    },
    onNext: function (tour) {
        jQuery("#step9-1").fadeOut(500).remove();
        jQuery("#step9-2").fadeOut(500).remove();
    },
    onPrev: function (tour) {
        jQuery("#wiki-post-block-5781").fadeOut(500);
        jQuery("#step9-1").fadeOut(500).remove();
        jQuery("#step9-2").fadeOut(500).remove();
    }
  }, {
    path: "/tour",
    element: "#tour-step10",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "right",
    content: "<a style='color: #f07d18; font-family: \"Lato-Bold\"; text-decoration: underline;'>Instructors only</a><br/>Socialize learning activities or<br/>problem-based assigments",
    onShow: function (tour) {
        jQuery("#wiki-post-block-2916").fadeIn(500);
        jQuery("#wiki-post-block-5788").css({"margin-bottom": "0px"}).fadeIn(500);
        jQuery("#wiki-comment-list-5788").fadeIn(500);
        jQuery("#wiki-post-block-5785").fadeIn(500);
        jQuery("#wiki-post-block-5781").css({"margin-bottom": "0px"}).fadeIn(500);
        jQuery("#wiki-post-block-5782").fadeIn(500);
    },
    onShown: function (tour) {
        jQuery(".popover").css({"margin-left": "-33%", "position": "absolute"});
        jQuery(".popover .arrow").css({"display": "none"});
    },
    onPrev: function (tour) {
        jQuery("#wiki-post-block-5782").fadeOut(500);
    }
  }, {
    path: "/tour",
    element: "#tour-step11",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "right",
    content: "<a style='color: #f07d18; font-family: \"Lato-Bold\"; text-decoration: underline;'>Instructors only</a><br/>Socialize course documents,<br/>handouts, or links to web pages",
    onShow: function (tour) {
        jQuery("#wiki-post-block-2916").fadeIn(500);
        jQuery("#wiki-post-block-5788").css({"margin-bottom": "0px"}).fadeIn(500);
        jQuery("#wiki-comment-list-5788").fadeIn(500);
        jQuery("#wiki-post-block-5785").fadeIn(500);
        jQuery("#wiki-post-block-5781").css({"margin-bottom": "0px"}).fadeIn(500);
        jQuery("#wiki-post-block-5782").fadeIn(500);
        jQuery("#wiki-post-block-5783").fadeIn(500);
        jQuery("#wiki-post-block-5846").fadeIn(500);
    },
    onShown: function (tour) {
        jQuery(".popover").css({"margin-left": "14%"});
        jQuery(".popover .arrow").css({"display": "none"});
    },
    onPrev: function (tour) {
        jQuery("#wiki-post-block-5783").fadeOut(500);
        jQuery("#wiki-post-block-5846").fadeOut(500);
    }
  }, {
    path: "/tour2",
    element: "#tour-step12",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "right",
    content: "<a style='color: #f07d18; font-family: \"Lato-Bold\"; text-decoration: underline;'>Instructors only</a><br/>Cliking on student name or<br/>\"New message\" direct you to<br/>their private feed",
    onShow: function (tour) {
    },
    onShown: function (tour) {
        if(jQuery("#step12-1").length === 0) {
            jQuery("#step2").prepend(step12_1);
        }
        jQuery("#step12-1").fadeIn(500);
        jQuery(".popover .arrow").css({"display": "none"});
    },
    onPrev: function (tour) {
        jQuery("#step12-1").fadeOut(500).remove();
    },
    onNext: function (tour) {
        jQuery("#step12-1").fadeOut(500).remove();
    }
  }, {
    path: "/tour2",
    element: "#tour-step13",
    title: "<a class='' data-role='end'>End tour</a>",
    placement: "left",
    content: "WikiGrads auto-organizes all<br/>student-instructor messaging<br/>and document enchange by<br/>course",
    onShow: function (tour) {
        jQuery("#wiki-main-menu-course li:nth-child(2) a").attr("class", "tooltip collapsible active-main-menu expanded");
        jQuery("#wiki-main-menu-course li:nth-child(2) ul").css({"overflow": "hidden", "display": "block"});
    },
    onShown: function (tour) {
        if(jQuery("#step13-1").length === 0) {
            jQuery("#step2").prepend(step13_1);
        }
        jQuery("#step13-1").fadeIn(500);
        jQuery(".popover").css({"top": "-10px", "margin-top": "65px", "margin-left": "-25px"});
        jQuery(".popover").prepend("<div class='tour-arrow-right-three'></div>");
    },
    onPrev: function (tour) {
        jQuery("#step13-1").fadeOut(500).remove();
        jQuery("#wiki-main-menu-course li:nth-child(2) a").attr("class", "tooltip collapsed collapsible");
        jQuery("#wiki-main-menu-course li:nth-child(2) ul").css({"display": "none"});
    },
    onNext: function (tour) {
        jQuery("#step13-1").fadeOut(500).remove();
        jQuery("#wiki-main-menu-course li:nth-child(2) a").attr("class", "tooltip collapsed collapsible");
        jQuery("#wiki-main-menu-course li:nth-child(2) ul").css({"display": "none"});
    }
  }, {
    path: "/tour3",
    element: "#tour-step14",
    placement: "top",
    template: template1,
    content: "The continuity of message<br/>and document exchanges<br/>between students and<br/>instructor(s) are kept intact<br/>within a feed",
    onShow: function (tour) {
        if(jQuery("#step14_1").length === 0) {
            jQuery("#step2").prepend(step14_1);
        }
        if(jQuery("#step14_2").length === 0) {
            jQuery("#step2").prepend(step14_2);
        }
        jQuery("#step14-1").fadeIn(500);
        jQuery("#step14-2").fadeIn(500);
        jQuery("#step13-1").fadeOut(500).remove();
    },
    onShown: function (tour) {
        jQuery(".popover").css({"margin-left": "15%"});
        jQuery(".popover .arrow").css({"display": "none"});
    },
    onPrev: function (tour) {
        jQuery("#step14-1").fadeOut(500).remove();
        jQuery("#step14-2").fadeOut(500).remove();
    },
    onNext: function (tour) {
        jQuery("#step14-1").fadeOut(500).remove();
        jQuery("#step14-2").fadeOut(500).remove();
    }
  }
  ],
  template: template,
  onEnd: function(tour) {
    tour.restart();
    document.location.href="/";
  }
});

// Initialize the tour
tour.init();

// Start the tour
tour.start();