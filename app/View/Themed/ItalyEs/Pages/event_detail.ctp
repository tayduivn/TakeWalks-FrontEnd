<?php foreach(array_slice(array_merge($initValues['dates_group'], $initValues['dates_private']), 0, 10) as $date): ?>
    <?php
    $dateKey = '';
    foreach ($date as $key => $value)
    {
        $dateKey = $key;
        break;
    }
    ?>
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "EducationEvent",
      "name": "<?php echo $event['name_listing'] != '' ? $event['name_listing'] : $event['name_short'] ?>",
      "startDate": "<?php echo date('Y-m-d\TH:i', strtotime($date[$dateKey]['date'] . ' ' . $date[$dateKey]['time'])) ?>",
      "location": {
         "@type": "Place",
         "name": "<?php echo $event['street'] ?>",
         "address": "<?php echo $event['city'] . ', ' . $event['country'] ?>"
      },
      "offers": {
         "@type": "Offer",
         "url": "<?php echo Router::url( $this->here, true ); ?>"
      },
      "description": "<?php echo $event['description_short'] ?>",
      "endDate": "<?php echo date('Y-m-d\TH:i', strtotime($date[$dateKey]['date'] . ' ' . $date[$dateKey]['time']) + ($event['duration'] * 60)) ?>",
      "image": "<?php echo $images[0]['images_name'] ?>",
      "url": "<?php echo Router::url( $this->here, true ); ?>"
    }
    </script>
<?php endforeach ?>
<header id="top-fixed" class="top-detail-nav">
    <div class="event-title">
        <div class="container">
            <h1 style="float: left;width: 40px;"><a href="/">Walks of Italy</a></h1>
            <a href="#book" class="book-tour-anchor">Reservar el Tour</a>
            <a href="#" style="float: right;width: 160px;"><h5>Mirar</h5></a>
            <h5><?php echo $arrcity['name'] . " - " . $event['name_listing'] ?></h5>
        </div>
    </div>
    <div class="event-nav-links">
        <div class="container">
            <a href="#key-details">Detalles Claves</a>
            <a href="#highlights">Lo Destacado</a>
            <!-- <a href="#description">Description</a>
            <a href="#sites-visited">Sites Visited</a> -->
            <a href="#reviews"><?php echo count($reviews) ?> Opiniones</a>
        </div>
    </div>
</header>

<div itemscope itemtype="http://schema.org/Product">
    <link itemprop="additionalType" href="http://www.productontology.org/id/Walking_tour"/>
    <nav id="breadcrumbs">
        <h2 itemprop="name"><?php echo $event['name_long'] ?></h2>
        <ol>
            <li>
            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a href="/" itemprop="url">
                    <span itemprop="title">Inicio</span>
                </a>
            </span>
            </li>
            <!-- <li>
            <span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                <a href="/<?php echo $domainsGroup['url_name'] ?>-tours" itemprop="url">
                    <span itemprop="title"><?php echo $domainsGroup['name'] ?> Tours</span>
                </a>
            </span>
            </li> -->
            <li><?php echo $event['name_listing'] ?></li>
        </ol>
        <p>
            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="price-a <?php echo $event['group_private'] != 'Private' ? 'group_price' : 'private_price' ?>">


                <link itemprop="seller" href="seller_info"/>
                <span>
                    <?php echo $event['group_private'] != 'Privado' ? 'Desde' : 'Precio para 2 personas' ?>
                </span>
                <meta itemprop="priceCurrency" content="EUR"/>
                <?php $adultPrice =  $event['group_private'] != 'Private' ? $event['adults_price'] : $event['private_base_price'] ?>
                <b style="display:inline-block;font-weight:500;margin-top: 18px;" itemprop="price" content="<?php echo $adultPrice ?>">
                    <?php echo ExchangeRate::convert($adultPrice)?>
                </b>
                <link itemprop="availability" href="http://schema.org/InStock"/>


            </span>


            <a href="#book-now" class="book_now">BOOK NOW</a>

            <span class="rating-a <?php echo isset($ratings[$event['id']]) ? $ratings[$event['id']]['letterClass'] : ''?>" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" style="<?php echo !isset($ratings[$event['id']]) ? 'display:none;' : ''?>">
                <meta itemprop="ratingValue" content="<?php echo isset($ratings[$event['id']]) ? $ratings[$event['id']]['average'] : ''?>"/>
                <?php echo isset($ratings[$event['id']]) ? 'Desde <span itemprop="reviewCount">' . $ratings[$event['id']]['amount'] . '</span> reviews' : ''?>
            </span>

        </p>
    </nav>
    <article class="event-detail-hero">
        <div class="player">
            <div class="pl-wrap">
                <iframe id="banner-video" src="<?php echo $event['video'] ?>" style="width: 100%; height: 100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
        </div>

        <div class="extra-expand">
            <?php if($event['video']): ?>
            <div class="play-button">
                <div class="watch">Mirar</div>
                <i id="play-expand" class="fa fa-play-circle playpause start"></i>
                <div class="video">Vídeo</div>
            </div>
            <?php endif ?>
            <figure
                style="background-image: url('https://app.resrc.it/O=20(40)/<?php echo str_replace('https:', 's=W1300/https:', $images[0]['images_name']) ?>')"></figure>
        </div>
    </article>

    <?php if ($charity && $charity['description'] && $charity['video']): ?>
        <?php echo $this->element('Pages/detail/positive_steps', array('description' => $charity['description'], 'video' => $charity['video'])); ?>
    <?php endif ?>

    <section id="content">
        <div class="columns-a no-match-height">
            <article>
                <h3 class="header-bordered" id="key-details">Detalles Claves</h3>
                <ul class="list-b key-facts-list">
                    <li><i class="fa fa-map-marker"></i> <span>Ciudad:</span><?php echo ucwords($domainsGroup['name']); ?></li>
                    <li><i class="fa fa-clock-o" ></i> <span>Duración</span><?php echo $event['display_duration'] ?></li>
                    <li><i class="fa fa-arrow-right"></i> <span>Hora de Inicio:</span><?php echo $event['display_time'] ?></li>
                </ul>
                <h3 class="header-bordered" id="highlights">Lo Destacado</h3>
                <ul class="list-triangles">
                    <li><?php echo $event['bullet1'] ?> </li>
                    <li><?php echo $event['bullet2'] ?> </li>
                    <li><?php echo $event['bullet3'] ?> </li>
                </ul>
                <section id="tab-target-overview" class="tab-target">
                    <?php echo $this->element('Pages/detail/hero_slider'); ?>
                </section>

                <section id="tab-target-description" class="tab-target">
                    <?php if (strlen($event['description_long']) > 1) : ?>
                        <h2 class="header-bordered" id="description" data-scroll="description">Descripción del Tour</h2>
                    <?php endif ?>
                    <?php foreach (explode("\n", $event['description_long']) as $n => $line) : ?>
                        <?php //if(trim($line) === '') continue; ?>
                        <?php if ($n == 0) : ?>
                            <h3><?php echo $line ?></h3>
                        <?php else: ?>
                            <p <?php echo $n > 7 && false ? 'class="hidden"' : ''; ?>>
                                <?php echo $line ?>
                            </p>
                        <?php endif ?>
                    <?php endforeach; ?>
                </section>
                <!-- Reviews Tab -->
                <div class="review-slider-wrapper" id="reviews">
                    <h3>Opiniones</h3>
                    <p class="reviews-info">5 estrellas de más de <?php echo count($reviews); ?> opiniones de nuestros viajeros</p>
                    <div class="review-slider">

                        <?php $i = 0;
                        foreach ($reviews as $review) : ?>
                            <?php
                            $stars = $review['event_rating'];
                            $length_comment = strlen($review['feedback_text']);
                            // only show 5-star reviews
                            if ($stars == 5 && $length_comment < 300 && $length_comment > 0) {
                                $i++;
                                if ($i == 10)
                                    break;
                                ?>
                                <div class="review" itemprop="review" itemscope itemtype="http://schema.org/Review">
                                    <span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                                        <span itemprop="ratingValue" content="<?=$stars ?>"></span>
                                    </span>
                                    <div class="review-body" style="height: 80px; min-height: 80px;
                                    overflow-y: hidden;" itemprop="reviewBody"
                                    ><?php echo $review['feedback_text'] ?></div>
                                    <div class="review-footer">
                                        <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                                            <p itemprop="name"><?php echo $review['first_name'] ?></p>
                                        </span>
                                        <div class="stars">
                                            <?php for($i=1; $i<=5; $i++): ?>
                                                <i class="fa fa-star<?= $i <= $stars ? '' : '-o' ?>"></i>
                                            <?php endfor ?>
                                        </div>
                                        <p class="review-date" itemprop="datePublished"><?php $fdate = explode(" ", $review['feedback_date']); echo $fdate[0] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php endforeach; ?>

                    </div> <!-- //.review-slider -->
                    <button class="more-reviews-btn show-hidden-reviews-btn">Ver todas
                        las <?php echo count($reviews); ?> Opiniones
                    </button>
                </div>

            </article>
            <aside>
                <a name="book-now"></a>
                <div class="calendar-a">
                    <form class="book" action="/add_to_cart" method="post" onsubmit="return ecAddToCart();">
                        <input type="hidden" id="ec_quantity" value=""/>
                        <input type="hidden" id="ec_price" value=""/>
                        <input type="hidden" name="events_id" value="<?php echo $event['id'] ?>"/>
                        <h3>Reservar un Tour</h3>
                        <nav class="tabs small">
                            <?php if ($event['group_private'] == 'Group'): ?>
                                <a class="group selected">En grupo</a>
                            <?php elseif ($event['group_private'] == 'Private'): ?>
                                <a class="private selected">Privado</a>
                            <?php else: ?>
                                <a class="group selected">En grupo</a>
                                <a class="private">Privado</a>
                            <?php endif; ?>
                        </nav>
                        <ol>
                            <li><a class="summary">
                                    1. Escoger Fecha<br/>
                                    <span></span>
                                </a>
                                <fieldset class="date">
                                    <div class="calendar"></div>
                                    <input type="hidden" name="date"/>
                                </fieldset>
                            </li>
                            <li><a class="summary">
                                    2. Escoger Horario<br/>
                                    <span></span>
                                </a>
                                <fieldset class="time" style="font-size: 1rem">
                                    <select name="time" data-placeholder="Escoger Horario">
                                        <option value=""></option>
                                    </select>
                                </fieldset>
                            </li>
                            <li><a class="summary">
                                    3. Número de Viajeros<br/>
                                    <span></span>
                                </a>

                                <fieldset class="people">
                                    <div class="private-details"><span class="fa fa-info-circle"></span> <span
                                            class="base-price"></span> el precio base incluye 2 entradas
                                    </div>
                                    <!-- 1 - Adults -->
                                    <div>
                                        <span class="person-type">Adultos</span>
                                        <!-- hack ... it has 0 opacity -->
                                        <span class="person-age-description adult-person-age">asd</span>
                                        <span
                                            class="person-price adults"><?php echo ExchangeRate::convert($event['adults_price']) ?></span>
                                        <div class="people-number-select-wrapper">
                                            <select name="adults" id="adults" class="people-number-select"
                                                    data-minimumresultsforsearch="-1">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>

                                            </select>
                                        </div>
                                    </div>

                                    <!-- 2 - Infants -->
                                    <div>
                                        <span class="person-type">Infantes</span>
                                        <span class="person-age-description">(Menos 4)</span>
                                        <span
                                            class="person-price infants"><?php echo ExchangeRate::convert($event['infants_price']) ?></span>
                                        <div class="people-number-select-wrapper">
                                            <select name="infants" id="infants" class="people-number-select"
                                                    data-minimumresultsforsearch="-1">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 3 - Children -->
                                    <div>
                                        <span class="person-type">Niños</span>
                                        <span class="person-age-description">(4 - 12)</span>
                                        <span
                                            class="person-price children"><?php echo ExchangeRate::convert($event['children_price']) ?></span>
                                        <div class="people-number-select-wrapper">
                                            <select name="children" id="children" class="people-number-select"
                                                    data-minimumresultsforsearch="-1">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 4 - Students -->
                                    <div>
                                        <span class="person-type">Estudiantes</span>
                                        <span class="person-age-description">(13 - 22)</span>
                                        <span
                                            class="person-price students"><?php echo ExchangeRate::convert($event['students_price']) ?></span>
                                        <div class="people-number-select-wrapper">
                                            <select name="students" id="students" class="people-number-select"
                                                    data-minimumresultsforsearch="-1">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 4 - Adults -->

                                    <!-- 5 - Seniors -->
                                    <input type="hidden" name="seniors" value="0">

                                </fieldset>
                            </li>
                        </ol>

                        <fieldset class="submit">
                            <input type="hidden" name="type"
                                   value="<?php echo $event['group_private'] == 'Private' ? 'private' : 'group' ?>"/>
                            <p class="summary">1 Viajeros por <span class="total-price">$49</span></p>
                            <button type="submit" class="green button large"><i class="fa fa-cart-plus"></i>RESERVAR
                                AHORA
                            </button>
                        </fieldset>
                    </form>

                </div>
            </aside>
        </div>
        <?php if($event['important_information'] != null): ?>

            <article class="module-a">
                <h2><i class="fa fa-info-circle"></i> Información Importante</h2>
                <p class="disclaimer">
                    Antes de viajar, lee por favor la información sobre requisitos de entrada y interrupciones posibles.
                </p>
                <div class="activity-show-detail-info">
                    <p class="link-a">
                        <a href="#">Mostrar Información</a>
                    </p>
                </div>
                <p class="information-content"><?php echo nl2br($event['important_information']) ?></p>
            </article>

        <?php endif ?>

        <?php if(!empty($relatedTours)): ?>
            <h2 class="scheme-c">Similar Tours</h2>
            <ul class="gallery-a">
                <?php foreach ($relatedTours as $tour): ?>
                    <li data-id="<?php echo $tour['Event']['id'] ?>">
                        <?php $imageUrl = "http://placehold.it/314x190"; ?>
                        <?php foreach($tour['Event']['EventsImage'] as $image): ?>
                            <?php if($image['feature'] == 1) {
                                $imageUrl = $image['images_name'];
                                break;
                            } ?>
                        <?php endforeach ?>
                        <?php if (!empty($tour['Event']['EventsImage'])): ?>
                            <img src="<?php echo $this->ReSrc->resrcUrl($imageUrl, 314, 'c=AR4x3/'); ?>" alt="<?php echo $tour['Event']['EventsImage'][0]['alt_tag'] ?>">
                        <?php else: ?>
                            <img src="http://placehold.it/314x190" alt="Placeholder" width="314" height="190">
                        <?php endif ?>
                        <span class="title"><?php echo $tour['Event']['name_listing'] ?></span>
            <span class="rating-a <?php echo isset($ratings[$tour['Event']['id']]) ? $ratings[$tour['Event']['id']]['letterClass'] : ''?>" style="<?php echo !isset($ratings[$event['id']]) ? 'display:none;' : ''?>">
                Desde <a href="./"><?php echo isset($ratings[$tour['Event']['id']]) ? $ratings[$tour['Event']['id']]['amount'] : ''?> reviews</a>
            </span>
                        <a class="link-a" href="/<?php echo $tour['Event']['EventsDomainsGroup'][0]['DomainsGroup']['url_name'] ?>-tours/<?php echo $tour['Event']['url_name'] ?>"><i class="fa fa-info-circle"></i> Más Información</a>
                        <span class="price-a"><span>desde</span> <?php echo ExchangeRate::convert($tour['Event']['adults_price'] ?: $tour['Event']['private_base_price']) ?></span></li>

                <?php endforeach ?>
            </ul>
        <?php endif ?>

    </section>
</div>


<div class="hidden-reviews">
    <div class="close-hidden-reviews"></div>
    <div class="hidden-reviews-container">
        <div class="hidden-review-column">
            <?php $i = 0;
            $j = 0;
            foreach ($reviews as $review) : ?>
                <?php
                $stars = $review['event_rating'];
                $i++;
                $j++;
                ?>
                <div class="hidden-review">
                    <div class="hidden-review-body">
                        <?php echo ($review['feedback_text']) ?: '<i>(No comment)</i>'; ?>
                    </div>
                    <div class="hidden-review-footer">
                        <p><?php echo $review['first_name'] ?></p>
                        <div class="stars">
                            <?php if ($stars == 5) { ?>
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                            <?php } else if ($stars == 4) { ?>
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>
                            <?php } else if ($stars == 3) { ?>
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                            <?php } else if ($stars == 2) { ?>
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                            <?php } else if ($stars == 1) { ?>
                                <i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                            <?php } ?>
                        </div>
                        <p class="review-date"><?php $fdate = explode(" ", $review['feedback_date']); echo $fdate[0]; ?></p>
                    </div>
                </div>
                <?php
                if ($j == 1) {
                    echo '</div><!-- column --><div class="hidden-review-column">';
                    $j = 0;
                }
                if ($i == 48)
                    break;
                ?>

            <?php endforeach; ?>
        </div><!-- column -->
    </div>
    <a href="/eventrewiewshtml?e=<?php echo $event['id']; ?>&p=2"></a>
</div>

<script>
$(document).ready(function(){
        $('.hidden-reviews').jscroll({
            loadingHtml: '<div align="center"><img src="/img/loading.gif" alt="Loading" /><div>'
        });
    });
</script>

