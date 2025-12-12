@extends('home.layouts.app')
@section('style')
<style>
.blog-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 100px 0;
    color: white;
    position: relative;
    overflow: hidden;
}

.blog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.blog-search {
    background: white;
    border-radius: 50px;
    padding: 5px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    max-width: 500px;
    margin: 30px auto 0;
}

.blog-search input {
    border: none;
    padding: 15px 25px;
    border-radius: 50px;
    width: 100%;
    font-size: 16px;
}

.blog-search input:focus {
    outline: none;
    box-shadow: none;
}

.blog-search .btn {
    border-radius: 50px;
    padding: 15px 30px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
    color: white;
    font-weight: 600;
}

.blog-filters {
    background: #f8f9fa;
    padding: 30px 0;
    border-bottom: 1px solid #e9ecef;
}

.filter-btn {
    background: white;
    border: 2px solid #e9ecef;
    color: #6c757d;
    padding: 10px 20px;
    border-radius: 25px;
    margin: 5px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.filter-btn:hover, .filter-btn.active {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-color: #667eea;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.blog-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    border: none;
}

.blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.blog-card .post-img {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.blog-card .post-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card:hover .post-img img {
    transform: scale(1.1);
}

.blog-card .post-category {
    position: absolute;
    top: 20px;
    left: 20px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.blog-card .card-body {
    padding: 30px;
}

.blog-card .title {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 15px;
    color: #2c3e50;
}

.blog-card .title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.blog-card .title a:hover {
    color: #667eea;
}

.blog-card .post-excerpt {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 14px;
}

.blog-card .post-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 20px;
    border-top: 1px solid #f1f3f4;
}

.blog-card .author-info {
    display: flex;
    align-items: center;
}

.blog-card .post-author-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 12px;
    border: 2px solid #f1f3f4;
}

.blog-card .post-author {
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    font-size: 14px;
}

.blog-card .post-date {
    color: #6c757d;
    font-size: 12px;
    margin: 0;
}

.blog-card .read-more {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.blog-card .read-more:hover {
    color: #764ba2;
    text-decoration: none;
}

.blog-card .read-more i {
    margin-left: 5px;
    transition: transform 0.3s ease;
}

.blog-card .read-more:hover i {
    transform: translateX(5px);
}

.pagination-modern {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 50px 0;
}

.pagination-modern .page-link {
    border: none;
    background: white;
    color: #6c757d;
    padding: 12px 18px;
    margin: 0 5px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.pagination-modern .page-link:hover,
.pagination-modern .page-link.active {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.blog-stats {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 60px 0;
    margin: 80px 0;
    border-radius: 20px;
}

.stat-item {
    text-align: center;
    padding: 20px;
}

.stat-number {
    font-size: 48px;
    font-weight: 700;
    display: block;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 16px;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.loading-spinner {
    display: none;
    text-align: center;
    padding: 40px;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fade-in {
    animation: fadeIn 0.6s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .blog-hero {
        padding: 60px 0;
    }
    
    .blog-card .card-body {
        padding: 20px;
    }
    
    .filter-btn {
        margin: 3px;
        padding: 8px 15px;
        font-size: 14px;
    }
}
</style>
@endsection
@section('content')
<main class="main">
    <!-- Hero Section -->
    <section class="blog-hero">
        <div class="container position-relative">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Nuestro Blog</h1>
                    <p class="lead mb-4">Descubre las últimas tendencias, consejos y noticias de nuestro sector. Mantente informado con contenido de calidad y actualizado.</p>
                    
                    <!-- Search Bar -->
                    <div class="blog-search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar artículos..." id="blogSearch">
                            <button class="btn" type="button" id="searchBtn">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="blog-filters">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h5 class="mb-3">Filtrar por categoría:</h5>
                        <div class="filter-buttons">
                            <a href="#" class="filter-btn active" data-filter="all">Todos</a>
                            <a href="#" class="filter-btn" data-filter="tecnologia">Tecnología</a>
                            <a href="#" class="filter-btn" data-filter="negocios">Negocios</a>
                            <a href="#" class="filter-btn" data-filter="innovacion">Innovación</a>
                            <a href="#" class="filter-btn" data-filter="tendencias">Tendencias</a>
                            <a href="#" class="filter-btn" data-filter="consejos">Consejos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">

      <div class="container">
        <div class="row gy-4">

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="{{url('frontend/img/blog/blog-1.jpg')}}" alt="" class="img-fluid">
              </div>

              <p class="post-category">Politics</p>

              <h2 class="title">
                <a href="blog-details.html">Dolorum optio tempore voluptas dignissimos</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="{{url('frontend/img/blog/blog-author.jpg')}}" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Maria Doe</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jan 1, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="{{url('frontend/img/blog/blog-2.jpg')}}" alt="" class="img-fluid">
              </div>

              <p class="post-category">Sports</p>

              <h2 class="title">
                <a href="blog-details.html">Nisi magni odit consequatur autem nulla dolorem</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="{{url('frontend/img/blog/blog-author-2.jpg')}}" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Allisa Mayer</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jun 5, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="{{url('frontend/img/blog/blog-3.jpg')}}" alt="" class="img-fluid">
              </div>

              <p class="post-category">Entertainment</p>

              <h2 class="title">
                <a href="blog-details.html">Possimus soluta ut id suscipit ea ut in quo quia et soluta</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="{{url('frontend/img/blog/blog-author-3.jpg')}}" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Mark Dower</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jun 22, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="{{url('frontend/img/blog/blog-4.jpg')}}" alt="" class="img-fluid">
              </div>

              <p class="post-category">Sports</p>

              <h2 class="title">
                <a href="blog-details.html">Non rem rerum nam cum quo minus olor distincti</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="{{url('frontend/img/blog/blog-author-4.jpg')}}" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Lisa Neymar</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jun 30, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="{{url('frontend/img/blog/blog-5.jpg')}}" alt="" class="img-fluid">
              </div>

              <p class="post-category">Politics</p>

              <h2 class="title">
                <a href="blog-details.html">Accusamus quaerat aliquam qui debitis facilis consequatur</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="{{url('frontend/img/blog/blog-author-5.jpg')}}" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Denis Peterson</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Jan 30, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="{{url('frontend/img/blog/blog-6.jpg')}}" alt="" class="img-fluid">
              </div>

              <p class="post-category">Entertainment</p>

              <h2 class="title">
                <a href="blog-details.html">Distinctio provident quibusdam numquam aperiam aut</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="{{url('frontend/img/blog/blog-author-6.jpg')}}" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Mika Lendon</p>
                  <p class="post-date">
                    <time datetime="2022-01-01">Feb 14, 2022</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

        </div>
      </div>

    </section><!-- /Blog Posts Section -->

    <!-- Blog Pagination Section -->
    <section id="blog-pagination" class="blog-pagination section">

      <div class="container">
        <div class="d-flex justify-content-center">
          <ul>
            <li><a href="#"><i class="bi bi-chevron-left"></i></a></li>
            <li><a href="#">1</a></li>
            <li><a href="#" class="active">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li>...</li>
            <li><a href="#">10</a></li>
            <li><a href="#"><i class="bi bi-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>

    </section><!-- /Blog Pagination Section -->
 </main>
@endsection
@section('script')
@endsection