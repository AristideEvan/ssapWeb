@extends('layouts.front')

@section('content')
    <style>
        .contact-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }

        .contact-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .contact-header h2 {
            color: #007647;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .contact-header p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .form-control {
            border-radius: 5px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #007647;
            box-shadow: 0 0 0 0.2rem rgba(0, 118, 70, 0.25);
        }

        .btn-contact {
            background-color: #007647;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }

        .btn-contact:hover {
            background-color: #006341;
            transform: translateY(-2px);
        }

        .contact-info {
            margin-top: 40px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(0, 118, 70, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #007647;
            font-size: 20px;
        }

        .contact-details h5 {
            margin-bottom: 5px;
            font-weight: 600;
        }

        .contact-details p {
            margin: 0;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .contact-section {
                padding: 40px 0;
            }

            .contact-header {
                margin-bottom: 30px;
            }
        }
    </style>

    <section class="contact-section">
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <div class="contact-header" data-aos="fade-down">
                <h2>Contactez-nous</h2>
                <p>Nous sommes à votre écoute pour répondre à toutes vos questions</p>
            </div>

            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="contact-card" data-aos="fade-right">
                        <form method="POST" action="{{ route('contact') }}" id="contactForm">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="name" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="subject" class="form-label">Sujet</label>
                                <input type="text" class="form-control" name="subject" id="subject"
                                    value="{{ old('subject') }}">
                            </div>

                            <div class="form-group mb-4">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" name="message" id="message" rows="5" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-contact">
                                    <i class="fas fa-paper-plane me-2"></i> Envoyer le message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="contact-card" data-aos="fade-left">
                        <h4 class="mb-4">Nos coordonnées</h4>

                        <div class="contact-info">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Adresse</h5>
                                    <p>B.P :1530, Bamako, Mali,
                                    </p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Téléphone</h5>
                                    <p>(223) 20 22 47 06</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-fax"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Fax</h5>
                                    <p>(223) 20 22 78 31</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Email</h5>
                                    <p>administration.insah@cilss.int</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="contact-details">
                                    <h5>Site web</h5>
                                    <p>http://insah.cilss.int</p>
                                </div>
                            </div>
                        </div>

                        <div class="social-links mt-4">
                            <h5 class="mb-3">Suivez-nous</h5>
                            <a href="#" class="text-decoration-none me-3"><i
                                    class="fab fa-facebook-f fa-lg text-primary"></i></a>
                            <a href="#" class="text-decoration-none me-3"><i
                                    class="fab fa-twitter fa-lg text-info"></i></a>
                            <a href="#" class="text-decoration-none me-3"><i
                                    class="fab fa-linkedin-in fa-lg text-primary"></i></a>
                            <a href="#" class="text-decoration-none"><i
                                    class="fab fa-instagram fa-lg text-danger"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Validation du formulaire
        (function() {
            'use strict';

            const form = document.getElementById('contactForm');

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        })();
    </script>
@endsection
