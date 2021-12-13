<!doctype html>
<html lang="en">
<head>

</head>
<body>


<div id="content2" style="background: #fff;border-bottom: 1px solid #ffffff;">
    <div class="tokenDet"
         style="padding: 15px;border: 1px solid #000;width: 80%;margin: 0 auto;position: relative;overflow: hidden;">
        <div class="title" style="text-align: center; color: green; border-bottom: 1px solid #000;margin-bottom: 15px;">
            <h2>Entrance Exam Hall Ticket</h2>
        </div>
        <div class="parentdiv" style="display: inline-block;width: 100%;position: relative;">
            <div class="innerdiv" style="width: 80%;float: left;">
                <div class="restDet">
                    <div class="div">
                        <div class="label" style="width: 30%;float: left;">
                            <strong>Name</strong>
                        </div>
                        <div class="data" style="width: 70%;display: inline-block;">
                            <span>John Test</span>
                        </div>
                        <div class="label" style="width: 30%;float: left;">
                            <strong>D.O.B.</strong>
                        </div>
                        <div class="data" style="width: 70%;display: inline-block;">
                            <span>17th April, 1995</span>
                        </div>
                        <div class="label" style="width: 30%;float: left;">
                            <strong>Address</strong>
                        </div>
                        <div class="data" style="width: 70%;display: inline-block; color: blue">
                            <span>P.S. Srijan Corporate Park, Saltlake, Sector 5, Kolkata-91</span>
                        </div>
                        <div class="label" style="width: 30%;float: left;">
                            <strong>Contact Number</strong>
                        </div>
                        <div class="data" style="width: 70%;display: inline-block;">
                            <span>xxx4563210</span>
                        </div>
                        <div clblackass="label" style="width: 30%;float: left;">
                            <strong>Email Id</strong>
                        </div>
                        <div class="data" style="width: 70%;display: inline-block;">
                            <span>test@test.com</span>
                        </div>
                        <div class="label" style="width: 30%;float: left;">
                            <strong>Parent(s) Name</strong>
                        </div>
                        <div class="data" style="width: 70%;display: inline-block;">
                            <span>S. Test</span><br /><span>7896541230</span>
                        </div>
                        <div class="label" style="width: 30%;float: left;">
                            <strong>Exam Center</strong>
                        </div>
                        <div class="data" style="width: 70%;display: inline-block;">
                            <span>Institute of Engineering & Management</span>
                        </div>
                        <div class="label" style="width: 30%;float: left;">
                            <strong>Hall Number</strong>
                        </div>
                        <div class="data" style="width: 70%;display: inline-block;">
                            <span>COM-32</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sideDiv" style="width: 20%;float: left;">
                <div class="atts" style="float: left;width: 100%;">
                    <div class="photo" style="width: 115px;height: 150px;float: right;">
                        <img src="https://cdn1.iconfinder.com/data/icons/baby-and-kids-7/50/75-512.png"
                             style="width: 100%;" />
                    </div>
                    <div class="sign"
                         style="position: absolute;bottom: 0;right: 0;border-top: 1px dashed #000;left: 80%;text-align: right;">
                        <small>Self Attested</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button class="btn btn-info" id="downloadPDF">Download PDF</button>
<script>
    /*
 $('#cmd2').click(function() {
       var options = {
         //'width': 800,
       };
       var pdf = new jsPDF('p', 'pt', 'a4');
       pdf.addHTML($("#content2"), -1, 220, options, function() {
         pdf.save('admit_card.pdf');
       });
 });
 */
    $('#downloadPDF').click(function () {
        domtoimage.toPng(document.getElementById('content2'))
            .then(function (blob) {
                var pdf = new jsPDF('l', 'pt', [$('#content2').width(), $('#content2').height()]);

                pdf.addImage(blob, 'PNG', 0, 0, $('#content2').width(), $('#content2').height());
                pdf.save("test.pdf");

                that.options.api.optionsChanged();
            });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.2.0/jspdf.umd.min.js"></script>
</body>
</html>