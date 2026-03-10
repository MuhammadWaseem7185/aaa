<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .contact-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            overflow: hidden;width:95% ; margin-left:auto;margin-right:auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .contact-info {
            background: linear-gradient(to bottom right, #e73c7e, #ee7752);
            color: white;
            padding: 40px;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #eee;
        }
        .btn-send {
            background: linear-gradient(to right, #e73c7e, #ee7752);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-send:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(231, 60, 126, 0.4);
            color: white;
        }
    </style>
</head>
<body>
  


<div class=" py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="contact-card">
                <div class="row g-0">
                    <div class="col-md-5 contact-info">
                        <div class="container">
                        <h2 class="fw-bold mb-4">Get In Touch</h2>
                        <p class="mb-5">Have any questions or feedback? Contact us, our team will get back to you soon.</p>
                        
                        <div class="d-flex mb-4">
                            <i class="fa fa-map-marker-alt me-3 mt-1"></i>
                            <div>
                                <h5>Address</h5>
                                <p class="small">Main Boulevard, Gulberg III, Lahore, Pakistan</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <i class="fa fa-phone me-3 mt-1"></i>
                            <div>
                                <h5>Phone</h5>
                                <p class="small">+92 300 12345678910</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <i class="fa fa-envelope me-3 mt-1"></i>
                            <div>
                                <h5>Email</h5>
                                <p class="small">support@yourwebsite.com</p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <a href="https://www.facebook.com/" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                            <a href="https://web.whatsapp.com/" class="text-white me-3"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-7 p-5">
                        <h2 class="fw-bold text-dark mb-4">Send Message</h2>
                      <form action="{{ route('contactusstore') }}" method="POST">
                         @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Full Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Ali Khan">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="ali@email.com">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Subject</label>
                                <input type="text" name="subject" class="form-control" placeholder="Order Issue / Feedback">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Message</label>
                                <textarea class="form-control" name="message" rows="4" placeholder="Write your problem here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-send w-100">Send Message <i class="fa fa-paper-plane ms-2"></i></button>
                        </form>
                        
                    @if(session('success'))
<div id="success-message" class="alert alert-success mt-3">
    {{ session('success') }}
</div>

<script>
    setTimeout(function() {
        const msg = document.getElementById('success-message');
        if(msg){
            msg.style.transition = "opacity 1s";
            msg.style.opacity = 0;
            setTimeout(() => msg.remove(), 1000); // remove from DOM after fade
        }
    }, 5000); // hide after 5 seconds
</script>
@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   
</body>
</html>