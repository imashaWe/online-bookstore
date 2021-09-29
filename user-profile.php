<?php require_once('header.php'); ?>
    <div class="container-fluid mb-5" style="background-image: url('assets/images/auth-cover.jpg')">
        <h1 style="text-align: center; color: white; ">Profile</h1>
        <div class="col-lg-4">
            <div class="card-body text-center shadow" style="text-align: center">
                <img class="rounded-circle mb-3 mt-4" style="text-align: center" src="assets/images/profile.png"
                     width="160" height="160">
                <div class="mb-3">
                    <button class="btn btn-info btn-sm" type="button">Change Photo</button>
                </div>
            </div>
        </div>
    </div>

    </div>
    <div class="container px-4">
        <div class="row gx-5">
            <div class="col">
                <div class="p-3 border bg-light">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <p class="text-primary m-0 fw-bold">User Details</p>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="first_name">
                                                        <strong>First Name</strong></label><input class="form-control"
                                                                                                  type="text"
                                                                                                  id="first_name"
                                                                                                  placeholder="name 1"
                                                                                                  name="first_name">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="last_name"><strong>Last
                                                            Name</strong></label><input class="form-control" type="text"
                                                                                        id="last_name"
                                                                                        placeholder="name 2"
                                                                                        name="last_name"></div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="email"><strong>Email
                                                        Address</strong></label><input class="form-control"
                                                                                       type="email" id="email"
                                                                                       placeholder="user@gmail.com"
                                                                                       name="email"></div>
                                        </div>
                                        <div class="mb-3 mt-2" style="text-align: center">
                                            <button class="btn btn-primary btn-sm" type="submit">Save Settings</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-4 mt-3 mb-5">
        <div class="row gx-5">
            <div class="col">
                <div class="p-3 border bg-light">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Contact Details</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label"
                                                                 for="city"><strong>Address Line
                                                    1</strong></label><input
                                                    class="form-control" type="text" id="Address Line 1"
                                                    placeholder="Lane 1"
                                                    name="city"></div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label"
                                                                 for="country"><strong>Address Line
                                                    2</strong></label><input
                                                    class="form-control" type="text" id="Address Line 2"
                                                    placeholder="Lane 2"
                                                    name="country"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label"
                                                                 for="city"><strong>Town/City</strong></label><input
                                                    class="form-control" type="text" id="town/city"
                                                    placeholder="Colombo"
                                                    name="city"></div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label"
                                                                 for="country"><strong>Postcode/Zip</strong></label>
                                            <input class="form-control" type="text" id="Postcode/Zip"
                                                    placeholder="00001"
                                                    name="country"></div>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2" style="text-align: center">
                                    <button class="btn btn-primary btn-sm" type="submit">Save&nbsp;Settings</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once('footer.php'); ?>