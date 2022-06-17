
    <div class="blog_right_sidebar">
        <aside class="single_sidebar_widget search_widget">
            <form action="{{ route('blog.wfilter', ['category' => $category]) }}" method="get">
            <div class="input-group">
                <input name="q" type="text" class="form-control" placeholder="ბლოგში ძებნა" value="{{ app('request')->input('q') }}">

                <span class="input-group-btn">
                                  <button class="btn btn-default" type="submit">
                                      <i class="fas fa-search"></i>
                                  </button>
                              </span>
            </div>
            </form>
            <!-- /input-group -->
            <div class="br"></div>
        </aside>
        <aside class="single_sidebar_widget author_widget">
            <img class="author_img rounded-circle" src="https://yt3.ggpht.com/ytc/AAUvwnj1qRpx3QBfI56wsIgYP4ds4si1iuSn1O1EqXxdAw=s88-c-k-c0x00ffffff-no-rj" alt="ლალი ჭიღლაძე">
            <h4><a title="Facebook Personal Profile Page" style="color:#ff2185;" target="_blank" href="https://www.facebook.com/apoline.apolo">Lali Apoline Chighladze</a></h4>
            <p>Apolines Cuisine</p>
            <div class="social_icon">
                <a title="Official Facebook Page" target="_blank" href="https://www.facebook.com/%E1%83%90%E1%83%9E%E1%83%9D%E1%83%9A%E1%83%98%E1%83%9C%E1%83%94%E1%83%A1-%E1%83%A1%E1%83%90%E1%83%9B%E1%83%96%E1%83%90%E1%83%A0%E1%83%94%E1%83%A3%E1%83%9A%E1%83%9D-Apolines-cuisine-492934864213184">
                    <i class="fab fa-facebook"></i>
                </a>
                <a title="Official Yuotube Channel" target="_blank" href="https://www.youtube.com/channel/UCxaefpHmfRUav2lVrS15_bA">
                    <i class="fab fa-youtube"></i>
                </a>
                <a title="Official Instagram Profile" target="_blank" href="https://www.instagram.com/apolinescuisine/?hl=en">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <p style="text-align: justify;">ჩემი სახელია ლალი
                2002 წლიდან ვცხოვრობ ქალაქ მიუნხენში,პროფესიით ვარ მუსიკოსი  ვმუშაობ ერთ ერთ კლინიკაში განყოფილების დამხმარედ.
                ჩემს არხზე იხილავთ სხვასასხვა რეცეპტებს რომლებიც ჩემს სამზარეულოში მზადდება ჩემს მიერ.
                ჩემი სამზარეულო ჩემი  განტვირთვის ადგილია სადაც შემიძლია მრავალმხრივ კრეატიული ვიყო და ჩემი ემოციები თავიდან ბოლომდე  ჩავდო.
                ვიდეო რეცეპტებს იხილავთ კვირაში ორჯერ.
            </p>
            <div class="br"></div>
        </aside>
        <aside class="single_sidebar_widget ads_widget">
            <a href="#">
                <img class="img-fluid" src="img/blog/add.jpg" alt="">
            </a>
            <div class="br"></div>
        </aside>
        <aside class="single_sidebar_widget post_category_widget">
            <h4 class="widget_title">ბლოგის კატეგორიები</h4>
            <ul class="list cat-list">
                @forelse($all_blog_categories as $bcat)
                    <li>
                        <a class="d-flex justify-content-between" class="" href="{{ route('blog.wfilter',['category' => $bcat->url_name]) }}">
                            <p>{{ $bcat->blog_category_name }}</p>
                            <p>{{ $bcat->blogs_count }}</p>
                        </a>
                    </li>
                @empty
                    კატეგორიები ვერ მოიძებნა
                @endforelse

            </ul>
            <div class="br"></div>
        </aside>
    </div>

