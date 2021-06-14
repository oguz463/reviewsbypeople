<!-- Footer -->
    <footer class="footer footer--dark">
      <div class="container">
        <div class="footer__widgets">
          <div class="row">

            <div class="col-lg-3 col-md-6">
              <aside class="widget widget-logo">
                <a href="/">
                  <img width="277" height="88" src="/images/logo.png" class="logo__img" alt="" style="padding-bottom: 5px;width: auto;">
                </a>
                <p class="copyright">
                  © 2021 ReviewsByPeople <br>
                  All rights reserved.
                </p>

              </aside>
            </div>

            <div class="col-lg-2 col-md-6">
              <aside class="widget widget_nav_menu">
                <h4 class="widget-title">Useful Links</h4>
                <ul>
                  <li><a href="{{ route('home') }}">Home</a></li>
                  <li><a href="{{ route('review.index') }}">Reviews</a></li>
                  <li><a href="{{ route('about') }}">About</a></li>
                  {{-- <li><a href="{{ route('register') }}">Become an Author</a></li> --}}
                  <li><a href="{{ route('cookiespolicy') }}">Cookies Policy</a></li>
                  <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                  <li><a href="{{ route('termsofservice') }}">TOS</a></li>
                  <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
              </aside>
            </div>

            <div class="col-lg-4 col-md-6">
              <aside class="widget widget-popular-posts">
                <h4 class="widget-title">Follow Us</h4>
                    <a href="https://www.facebook.com/Reviewsbypeoplecom-274148516650018/" aria-label="facebook" target="_blank">
                      <img width="25" height="25" alt="facebook" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAFH0lEQVRoge2aW4hWVRTH/1tzgtRsvAR5wS6jSPMQRiIIMRF4GSUzMwWfonTIXnrK8iUUjAoigooIIsqwiz10IzQKdUgL84JCF0OLysJmZHTMccrJ8dfDWYdvz/Y737l85/NpFhz2fOus9V/r/+39rb3OPiMNy7A0RFxZQMAYSXdKapPUKmmGpOsljTGTPkldko5J+l5Sp6Q9zrm+snIoLIAD2oFtwL/kl3+A94BFQGlfal4SK4AjXlIXgb3AZmA5cCvQDIyyqxlotXtPA1+bTyyHgfuuJIEW4Asvgd+Ax4HJBbCmAOuB3z28HcDNjcjdD7wa+NsCdgFrgFEl4DYBHcApwz4LrCoj5zCQsyUTyxaguQFxxgNbvTibygR3wCsGfAF4qDTw5JgdwIDFfKks0Hgm+oCFpYBmi9sOnM86MzVLHrBa0lZJA5KWOuc+rzO5WxTtL+MlIemipLOSeiSdcM51B/btkj6WNErSKufctiJBW7wfduHlZGX3qaAyJcltVfw77F5voWpGpcRuqYPEHOAPL9GTwHb7QW8l2kh3Af1JRAwnLgDb8yawwhy7KFidgFnAOcPpBObVsD2cQmQCldJ8b9YEHJUde01BEg44aBjvAFel2NckYjaPmM0hsrQzRNUCoh270GYHLPAwRle5PwmYDzxg168ZiDQBJ8wuvXraugVYX4SEYbyVhAFsILnBTCRivk+a3btpCYwl6kgvUqB38nCOVUsMWGX6C8Bu+9L8a3oK7jRgkKg4XFPLMF5We+sg0WQYA8DI4N4Bu/doHfj7DGOBrx8R2LXZuKtoIEnX2djrnBv0Erha0u2S/pNUuKRL2mnjXb4yJNJq46E6Ao218Vygn6Sok+iu86nwoI2tvjIkMtPGn+oIFJdGAn38yBsSzCtHbZzpK0MiE208WWewRspfNk70leFG5R8UpAqwTNIbgTr8ckKZAZxOuLfQObc/xT+e0bG+MiSStCySpElS3hZmZA2fXzL4x7kN2d1DIn0WZLSk3hzJfSQp7JAvBZ+PKWrfQ5ks6TtJp5xzPRliVf2thUS6FRGZqnxEBpxzZ2oZWCm+zAaYbX9mLTBTbOzyleF6Pm7jjIygZcgsG4/WtKpInNvPvjKckSOSlkiaI+nDPMkATwS6Xufca/EHYIKkat30IhuzzshcL9fqAiyx7f+bLIjAyoTmD+B4YDurhi3APRljxi3KkA44nJHdkvolzQWmOOf+TME9Kum5QNcsqaOGT4+k16voD6TEEjBV0Wo5L+mrNOMPjPHmNOAE/5aUGfmxCK5hxCc672cxnm/GvcC4AsEaQgS4FjhjGHeH96vtwl8qquvjJK0tErRBsk5RZ33YObczzViSBCz1ZqXmw04V39JnBJgKnDb/9rzO8XHQTiCtf/L9SiUCjCB6mgTYkcc3BriRygFduEfU8iubyAZvdUzL4+uDLAMu2bUuo09pRICHiZ7RLwEr8+Yfgm2yBAaBBzPYl0IEWGsEADYWy/5y0Bc9Ms9S47yrXiJEr+me8Ug8XwoJL8BjHvh+oCXBrjAR4Cai95BYrI2lkvAC3U9lU+q3mbqhXiLAZOAFKu9DTgPLG0LCCzod+JSK9AMvA23AyDxEgDuAVxl68vgJRatTQUKLgW8ZKj3AZylEuoE3qZz3xrIPWHzFCIRiM/E2lT0nlixt/DmiF6ttSfhZpeZxfxZxznVK6gSaFP0LxzxJsyWFZ7ODitr+HxQ9FO1R9C8cA/XmMCzD0kD5H4UMEmqxCkstAAAAAElFTkSuQmCC">
                    </a>
                    <a href="https://twitter.com/ReviewsByPeople" aria-label="twitter" target="_blank">
                      <img width="25" height="25" alt="twitter" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAAFAklEQVRoge2Za2iWZRjH/882rW3qZM5h6Uq0zMxsRGmYLWyFhYKdD/TFKCL7kBTZAToQZNCBUOkkskQkR2ZEQZQjSAsrbBWY6XQbZq1gKm7p1B379eG+Xt97r+/5fbb3Q/t/ed/nua/rf/2v+3me+3Dd0ghGMIL/BYJ8BgdmSJonaZKkUkl/S2qStDMIgoF8aksJYBTwKLCXxDgMvAaUJ+AoAO4BvgCWxDOoBT4Azh+iJKqB/Z7gI0C9iX4RWAc0eu0dwL2e/0Tg4RiONbFBRgMHrXE3MD7kJBYDXca/B1gKFCawnQZsAAbMvh743rv2UR3rfEeMwTfAmJCSuBI4abzrgFFp+t0IdHqaBoDtwD92vSWe0yZrfA/4wf7vAipyTOJc70m/nYX/LGAV7ps4D3jXS6wO+A6o9x0i790CoMxLZj9wWQ6JrDSeRqAoB54KoCHOqwXQ7BuesJuVdj0G+NTunQQezCJ4APxlHLXZJmFcmxiMPu93gW/YbQ2l3r0C4BXgX2trAC7JIPg882vNJQnjqgXWA8uBZ7xElsca/mkNlyYgOWTtPcAa4II0gj9uPm/lmojHuQLot859Np7B5xb0zgQEZcBaoNfseu1x3wAUJPB53WyfDCmJN73YyxIZPWZGn6Uguxj40HolgjbgHdzIMsmzjYwwj4SUSJvx3ZrMqBw3YfWl8x0AFwKvAu2cjSPATuA3u14VUiJ/GF9VKsNVZtgIjE6TvBCoscf+s/fq+VgfUiJHjW9CbFvgGdVJGidpqaRRkuolPRAEQU+GwYolzZE0TW5VWylpYxAETdmncIa7R9JoSecEQdAbz6A0Ti8C7MAbjvMJoNI0HYvXHhltTknqs/9HvfYaSYuGUF8mmG6/ceekIkkKggBgr6QrJD0haZek2ZJKJCUdxYYRkWVSc1Ir4A17dFuHXlPmwC3rAVakMrwcN1v2ARcNk760AbRaIlelY/yRGTeQYLbOB4DZ3vyUegUNTDZjgNVAXosTEQAvmKa6TJxqgOPmuJmQt7yZArcCbzE9t2TqXE10H9EOPIcr3Qw7gCWm4yAJ9vipnCOJ+Fg7RHqTadlusVcms0v0QV8tKbYkhNzEOWwAFkm6XtIxSZmv14AZREsvLwHzgbKwhabQUAT8YhqeyoUoMgE1A2ND1Jhu/Kct/iHcQjRronKi6/9tw/lEcCWg0xb75jAI5wDHjHAPMDsEnalijgP2Wcz3wySeBRww4n5gC3A7MIUc6lQJYhUSLUH9SkiVTj9ACfAy0Ykygm4SFCuyiFEAbDTeDoZyvYerpGzwEhkA7gqBt8jj7QKuC0NvvECFwE3AV14SLUBNCNzjiZZCTwELw9DsB6jCVehXM3iW78QVKUpCiDEXaDLedmB+LmQf406IWnHnIm3WM7FowZUqcx6GgWL75iJlz93A1FxJf4wjuhs3amzFVdNn5ireYhUBDxEtzw7gdqbZT3geebH1tH+g8iVwG2keyKQRYzLwPNFzEoCfgGvD4I8NVoErTp/2gh3G1XfvB6ZkwFUMXINb/n/L4PLqPuBuQt60nUWG20jdJ2mZpLkxzZ2S9kn6XdJxu5bc0fJYSRMlzZQ0VYNX1j2SPpFbwX4dBAEh6T+DpL2CO6laLGmhXFJxj4vjoFfSAUk7JG2TE9+Vg86UyOjx4s5EpkuqkjRBrnwpSSclnZDUIWm/pNYgCPpD1DmCEeQL/wGFKDi9UOcq5gAAAABJRU5ErkJggg==">
                    </a>
                    <a href="https://pinterest.com/reviewsbypeoplecom" aria-label="pinterest" target="_blank">
                      <img width="25" height="25" alt="pinterest" src="data:image/png;base64,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">
                    </a>
                    <a href="https://instagram.com/reviewsbypeople" aria-label="instagram" target="_blank">
                      <img width="25" height="25" alt="instagram" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABmJLR0QA/wD/AP+gvaeTAAADx0lEQVRoge2au08UURTGD8YHBhDXErREMBY+wE4xJppITAAbW0Ji+A9QqX20BEIpobdQoxWs7w6tVUALZYlWugYEKvlZzLnZEZmde+/cWRq+ZDKb2XO+8525Z+5rRmQHO8gFdS7GQLuI9IvIJRFpFZEjItIQSMuqiJREZElEiiLyuK6ubiEQdwSgC3hO7fEM6AyRwB5gAthQ4h/AfaAXaAdCtYYADcrZB0xqLDT2OLDbl7gAvFCyVeA2cCCUcIv4B4A7wFqsdQ66kuyhUkpLQFdOem20nAC+qJbXwF4X5wl1XARactRpq6cFKKmmMVunLq3LVeBUzhqtAZzWMvsDnLZxMCV1uwb6nADcVW3FNMP2WO9Uswc7Fv+KPpMloGeL/5uBn6qxrRrRTTWazFVxcnzzHAAsJthM6f/D8eu7Ntld1POTPIQGgtF2KdECmNdsj/pG0fFnEHgMzAG/9ZgDHul/hQTfHm2VReBygo0p/7lqIpbVqMkjgf3ACPCLdJSBW0C9R5wm5ViuZgSAB3kL8C4mdBq4rnevQY8OvTYTs3uLxziVqtMnEU1i0TQ3cNbC5xyVMnYedIMnouVkWuIlDnMhomfplfrOupRZHomMqMtHlyRi/oVYy9x08AuXiIowD3ZqOVXhOa8cZRJ6M2edjokMqvm0peZqXEXlGrC0/0/n5gHRBb16fpCBw8Bw9Fa1soVji5jabg8Qt0O5kge5f+2DltaKmjda6q3G1ahcK5b2QUsrJIyOjawEPvim59YMHAZmQPzuS5AlkQ96PpeBw6Bbz+99CbIkYqbT1zJwGBiOMMsHjwGxrC7d6R6JPBdiA6LV7CBor6X2Zooybzsqb/IvAAvKMZzuYanTI5F6oqk4RBNA62SAQ8Ab9d3eSaP6xKfxC8B5C58LwCf12f5pfMyvRe+qQREYAo4RDXaN+nuIaOvTYNY1CdtEsix164l2YcqkowzcAPZ5xLFa6obYfDgIDAAPidYpK3p81GsDeKxdYvxWmw9mOt3nGyhvAFdV4z/Lh80DotmKDDOdzgfmJs8kWrDNW6ZpwHbLVI1Nr3KnRvqsAdzbqqySjDuJXiusYbN9XyMQve5YJ3qtcNLWaVwzLwEhpumZALRS2eAedXHcHSuxJeBMjjrTtJwEvqqWIq4vRXU8MMmsEb1kac5J71bxm/WZWFcNM97jj7bMmNYl2mNMAf1EGwaZ1+uxWI3KeVVjmN7pDzDq3BIJQY4DT6k9ilh2OK6fcLRJ5ROOIyJyWERCtcpviT7hKEnlE47Pgbh3sANf/AXz7u+5M19CfgAAAABJRU5ErkJggg==">
                    </a>
              </aside>
            </div>

            <div class="col-lg-3 col-md-6">
              <aside class="widget widget_mc4wp_form_widget">
                <h4 class="widget-title">Affiliate Disclosure</h4>
                <p>Disclosure: ReviewsByPeople.com is a participant in the Amazon Services LLC Associates Program, an affiliate advertising program designed to provide a means for us to earn fees by linking to Amazon.com and affiliated sites.</p>
              </aside>
            </div>

          </div>
        </div>
      </div> <!-- end container -->
    </footer> <!-- end footer -->


          <div id="back-to-top">
            <a href="#top" aria-label="Go to top">
              <svg class="bi bi-arrow-bar-up" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.354 5.854a.5.5 0 000-.708l-3-3a.5.5 0 00-.708 0l-3 3a.5.5 0 10.708.708L8 3.207l2.646 2.647a.5.5 0 00.708 0z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M8 10a.5.5 0 00.5-.5V3a.5.5 0 00-1 0v6.5a.5.5 0 00.5.5zm-4.8 1.6c0-.22.18-.4.4-.4h8.8a.4.4 0 010 .8H3.6a.4.4 0 01-.4-.4z" clip-rule="evenodd"/>
              </svg>
            </a>
          </div>

        </main> <!-- end main-wrapper -->


        <!-- jQuery Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" integrity="sha256-0rguYS0qgS6L4qVzANq4kjxPLtvnp5nn2nB5G1lWRv4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.1/flickity.pkgd.min.js" integrity="sha256-3Maq7M1TC8sOke8B4gRkhfGtETqGWq+xenQO7k2mHjI=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha512-ANkGm5vSmtDaoFA/NB1nVJzOKOiI4a/9GipFtkpMG8Rg2Bz8R1GFf5kfL0+z0lcv2X/KZRugwrAlVTAgmxgvIg==" crossorigin="anonymous"></script>
        @yield('js')
        <script src="{{asset('js/scripts.js')}}"></script>
      </body>
      </html>
