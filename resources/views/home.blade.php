@extends('layouts.app')

@section('content')
<header>
    <div class="topbar py-0 d-none d-sm-block bg-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div class="item">
                            <i class="fa fa-phone"></i>
                            <div>
                                <a href="tel:{{ $company->phone ?? '#' }}">{{ $company->phone ?? '+971 555 309 790' }}</a>
                            </div>
                        </div>
                        <div class="item">
                            <i class="fa fa-envelope-open"></i>
                            <div>
                                <a href="mailto:{{ $company->email ?? 'info@candidtecheim.com' }}">{{ $company->email ?? 'info@candidtecheim.com' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <ul class="social m-0">
                        <li>Follow Us</li>
                        <li><a href="{{ $company->facebook ?? '#' }}"><img src="{{ asset('upload/facebook.png') }}"></a></li>
                        <li><a href="{{ $company->instagram ?? '#' }}"><img src="{{ asset('upload/instagram.png') }}"></a></li>
                        <li><a href="{{ $company->linkedin ?? '#' }}"><img src="{{ asset('upload/linkedin.png') }}"></a></li>
                        <li><a href="{{ $company->twitter ?? '#' }}"><img src="{{ asset('upload/twitter.png') }}"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-sm navbar-light py-0">
        <div class="container">
            <a class="navbar-brand" href="#">Candidtech Interiors</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-sm-grow-0" id="navbarsExample03">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Our Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="navbar-right d-none d-sm-flex">
                <a class="btn1" href="#contact">Get A Quote</a>
            </div>
        </div>
    </nav>
</header>

<div class="owl-slide owl-carousel">
    <div class="item">
        <img src="@if(!empty($banner->background_image)){{ asset('storage/' . $banner->background_image) }}@else{{ asset('upload/s1.jpeg') }}@endif">
        <div class="desc">
            <h1>{{ $banner->title ?? 'Design the space' }}<br>{{ $banner->subtitle ?? 'Engineer the experience' }}</h1>
            @if(!empty($banner->button_text))
                <a class="btn1" href="{{ $banner->button_url ?? '#' }}">{{ $banner->button_text }}</a>
            @endif
        </div>
    </div>
</div>

<div class="welcome py-5 bg-grey" id="about">
    <div class="container-fluid px-sm-4">
        <div class="row g-5">
            <div class="col-md-6" data-aos="fade-right" data-aos-duration="700">
                <div class="about-img">
                    @if(!empty($about->image))
                        <figure class="shine"><img src="{{ asset('storage/' . $about->image) }}"></figure>
                    @else
                        <figure class="shine"><img src="{{ asset('upload/about1.jpeg') }}"></figure>
                    @endif
                    <h2>Candidtech</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="heading mb-3" data-aos="fade-left" data-aos-duration="700">
                    <span>Welcome To </span>
                    <h2>Candidtech Interiors</h2>
                </div>
                <div class="text-justify mb-4" data-aos="fade-up" data-aos-duration="700">
                    <p>{{ $about->content ?? 'At CandidTech, as one of the UAE’s leading fit-out contractors, we create luxury spaces where creativity is engineered to perfection.' }}</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <a class="item" href="#">
                            <h4>Our Vision</h4>
                            <img src="{{ asset('upload/layers.png') }}">
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a class="item" href="#">
                            <h4>Our Mission</h4>
                            <img src="{{ asset('upload/target.png') }}">
                        </a>
                    </div>
                </div>
                <a class="btn1 type2" href="#contact">Learn More</a>
            </div>
        </div>
    </div>
</div>

<div class="home_products py-5" id="services">
    <div class="container-fluid px-sm-4">
        <div class="heading text-center mb-5" data-aos="fade-left" data-aos-duration="700">
            <span>Our Services</span>
            <h2>Innovative design for every need</h2>
        </div>
        <div class="owl-4 owl-carousel">
            @forelse($services as $service)
                <a class="item" href="{{ $service->link ?? '#' }}">
                    <img class="w-100" src="@if(!empty($service->icon)){{ asset('storage/' . $service->icon) }}@else{{ asset('upload/service1.jpeg') }}@endif" alt="{{ $service->title }}">
                    <div class="desc">
                        <h4>{{ $service->title }}</h4>
                        <p>{{ $service->description }}</p>
                        <span class="btn"><i class="fa fa-arrow-right"></i></span>
                    </div>
                </a>
            @empty
                <div class="item">
                    <div class="desc">
                        <h4>No services added yet.</h4>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="enquiry_wrap py-5 bg-3" style="background-image: url('{{ asset('upload/bg.png') }}');" id="contact">
    <div class="container-fluid px-sm-5">
        <div class="row align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="form1 bg-white" data-aos="fade-left" data-aos-duration="700">
                    <div class="header2 text-white" data-aos="fade-left" data-aos-duration="700">
                        <h2 class="text-capitalize text-white mb-0">Get In Touch</h2>
                        <p class="mb-0">Please fill the form and send us:</p>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('contact.submit') }}" method="post">
                        @csrf
                        <div class="wrap-input-8">
                            <input class="input" type="text" name="name" value="{{ old('name') }}" placeholder="Name">
                            <span class="focus-border"><i></i></span>
                        </div>
                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                        <div class="wrap-input-8">
                            <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                            <span class="focus-border"><i></i></span>
                        </div>
                        @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                        <div class="wrap-input-8">
                            <input class="input" type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject">
                            <span class="focus-border"><i></i></span>
                        </div>
                        @error('subject')<div class="text-danger small">{{ $message }}</div>@enderror
                        <div class="wrap-input-8">
                            <textarea class="input d-block" name="message" rows="6" placeholder="Message">{{ old('message') }}</textarea>
                            <span class="focus-border"><i></i></span>
                        </div>
                        @error('message')<div class="text-danger small">{{ $message }}</div>@enderror
                        <div class="">
                            <button type="submit" class="btn1">Submit <span class="fa fa-arrow-right"></span><i></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8" data-aos="fade-right" data-aos-duration="700">
                <div class="heading mb-4" data-aos="fade-up" data-aos-duration="700">
                    <span>Know More</span>
                    <h2 class="text-white">Why Choose Us ?</h2>
                </div>
                <div class="features row">
                    @forelse($features as $feature)
                        <div class="col-md-4 my-2">
                            <div class="item">
                                <span class="count"></span>
                                <div class="icon">
                                    @if($feature->icon)
                                        <img src="{{ asset('storage/' . $feature->icon) }}" alt="{{ $feature->title }}">
                                    @else
                                        <img src="{{ asset('upload/trust.png') }}" alt="Feature">
                                    @endif
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title">{{ $feature->title }}</h4>
                                    <p>{{ $feature->description }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12 text-white">
                            <p>No feature items available yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="testimonials py-5 bg-grey" style="background-image: url('{{ asset('upload/bg4.jpg') }}');">
    <div class="container">
        <div class="heading mb-4" data-aos="fade-left" data-aos-duration="700">
            <span>Testimonial</span>
            <h2>Why people love us over others</h2>
        </div>
        <div class="owl-3 owl-carousel">
            @forelse($testimonials as $testimonial)
                <div class="item">
                    <div class="item-inner d-flex align-items-center gap-3">
                        <div class="item-thumb">
                            <img src="@if(!empty($testimonial->avatar)){{ asset('storage/' . $testimonial->avatar) }}@else{{ asset('upload/face.jpg') }}@endif" alt="{{ $testimonial->name }}">
                        </div>
                        <div class="item-content">
                            <h4>{{ $testimonial->name }}</h4>
                            <span>{{ $testimonial->position }}</span>
                        </div>
                    </div>
                    <div class="item-desc">
                        <p>{{ $testimonial->quote }}</p>
                    </div>
                    <div class="item-quote">
                        <i class="fa fa-quote-left"></i>
                    </div>
                </div>
            @empty
                <div class="item">
                    <div class="item-desc text-white">
                        <p>No testimonials have been added yet.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div id="portfolio" class="gallery py-5 text-center">
    <div class="container">
        <div class="heading text-center mb-4" data-aos="fade-left" data-aos-duration="700">
            <span>Our Work</span>
            <h2>Our Recent Projects</h2>
        </div>
        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-md-4">
                    <a class="item" href="@if(!empty($project->image)){{ asset('storage/' . $project->image) }}@else{{ asset('upload/service1.jpeg') }}@endif"><img src="@if(!empty($project->image)){{ asset('storage/' . $project->image) }}@else{{ asset('upload/service1.jpeg') }}@endif"></a>
                </div>
            @empty
                <div class="col-md-12">
                    <p>No projects have been published yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<footer class="bg-4 text-white">
    <div class="footer-top py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3" data-aos="fade-right" data-aos-duration="700">
                    <h4>About Us</h4>
                    <p>We deliver seamless style, functionality, and flawless execution across residential and commercial interiors.</p>
                    <a class="text-white" href="#"><u>Read More</u></a>
                </div>
                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-duration="700">
                    <h4>Quick Links</h4>
                    <ul class="links">
                        <li><a href="#services"><i class="fa fa-angle-double-right"></i> Our Services</a></li>
                        <li><a href="#portfolio"><i class="fa fa-angle-double-right"></i> Gallery</a></li>
                        <li><a href="#contact"><i class="fa fa-angle-double-right"></i> Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4" data-aos="fade-left" data-aos-duration="700">
                    <h4>Connect With Us</h4>
                    <ul class="footer-contact p-0 m-0">
                        <li><i class="fas fa-map-marker-alt"></i> {{ $company->address ?? 'Office No. 5, 2nd Floor, Arif 7 Bintoak Building, Karama - Dubai' }}</li>
                        <li><a href="tel:{{ $company->phone ?? '+971 555309790' }}"><i class="fas fa-phone"></i>{{ $company->phone ?? '+971 555309790' }}</a></li>
                        <li><a href="mailto:{{ $company->email ?? 'info@candidtecheim.com' }}"><i class="far fa-envelope"></i>{{ $company->email ?? 'info@candidtecheim.com' }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center py-3">
        <div class="container">
            <div class="d-flex justify-content-center">
                <p class="mb-0">Candidtech Interiors</p>
            </div>
        </div>
    </div>
</footer>

<a href="#" class="scrollToTop scroll-btn"><i class="fa fa-arrow-up"></i></a>
@endsection
