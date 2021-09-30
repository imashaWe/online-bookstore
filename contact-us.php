<?php require_once "header.php" ?>

<style>
    .contact-table td{
        padding-top: 2.1vh;
        padding-bottom: 2.1vh;
    }
</style>

<div class="container-fluid py-5" style="background-image: url('assets/images/auth-cover.jpg')">
    <h1 class="theme-text-heading text-light text-center pt-5">CONTACT US</h1>
    <div class="col-lg-4">
        <div class="card-body text-center shadow" style="text-align: center">
        </div>
    </div>
</div>

<br>
<div class="container">

    <div class="row gy-2">
        <div class="col-md-6">

            <div class="card">
                <div class="card-body">
                    <h3 class="theme-text-heading text-center">Send Us Message</h3>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label"></label>
                        <input type="email" class="form-control theme-text" id="exampleFormControlInput1"
                               placeholder="Your Email Address">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control theme-text" id="exampleFormControlTextarea1"
                                  placeholder="How Can We Help...?"
                                  rows="3"></textarea>
                        <br>
                        <div style="text-align: center">
                            <button type="submit" class="theme-btn theme-btn-primary-animated theme-text-title">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="theme-text-heading text-center">Contact Details</h3>
                    <table class="w-100 contact-table">
                        <tr>
                            <td class="theme-text-heading w-50">
                                <h4><i class="fas fa-map-marker-alt"></i> Address:</h4>
                            </td>
                            <td class="theme-text">
                                N0 10, <br> Daluagama, <br>Kelaniya</p>
                            </td>
                        </tr>
                        <tr >
                            <td class="theme-text-heading w-50">
                                <h4><i class="fas fa-phone-alt"></i> Let's Talk:</h4>
                            </td>
                            <td class="theme-text">
                                <p>(+94) 76 716 6879</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="theme-text-heading w-50">
                                <h4><i class="fas fa-envelope"></i> Email:</h4></h3>
                            </td>
                            <td class="theme-text">
                                <p> bookberriesbookberries@gmail.com</p>
                            </td>
                        </tr>
                    </table>


                </div>
            </div>

        </div>

    </div>
</div>

<?php require_once "footer.php" ?>
