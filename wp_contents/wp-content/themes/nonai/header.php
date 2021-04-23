<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php wp_title(' '); ?><?php if ( wp_title(' ', false) ) { echo ''; } ?> <?php bloginfo('name'); ?></title>

    <meta name="description" content="脳神経血管内治療専門医を目指す方必見。採用情報から入局後のキャリアパスをはじめ、チーム医療による取り組み、日々の活動など最新情報を紹介します。脳卒中、神経救急診療のプロフェッショナルとして医療最前線で働く仲間を募集しています。">
    <meta name="keywords" content="昭和大学,昭和大学江東豊洲病院,脳神経内科">


    <meta name="robots" content="all">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:site_name" content="昭和大学江東豊洲病院 脳神経内科">
    <meta property="og:title" content="<?php wp_title(' '); ?><?php if ( wp_title(' ', false) ) { echo ''; } ?> <?php bloginfo('name'); ?>">
    <meta property="og:image" content="<?php echo home_url( '/' ); ?>common/images/ogp.jpg">
    <meta property="og:type" content="website">
    <meta property="og:description" content="脳神経血管内治療専門医を目指す方必見。採用情報から入局後のキャリアパスをはじめ、チーム医療による取り組み、日々の活動など最新情報を紹介します。脳卒中、神経救急診療のプロフェッショナルとして医療最前線で働く仲間を募集しています。">
    <meta property="og:url" content="<?php echo home_url( '/' ); ?>">
    <link rel="shortcut icon" href="<?php echo home_url( '/' ); ?>common/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo home_url( '/' ); ?>common/images/apple-touch-icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/reset.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/layout.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/layout_sp.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/style_sp.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/component.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/print.css" type="text/css" media="print" />
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/zdo_drawer_menu.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo home_url( '/' ); ?>common/css/colorbox.css" media="all" />
    <link rel="index" href="/index.html" />
    
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo home_url( '/' ); ?>common/carousel/css/carousel.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo home_url( '/' ); ?>common/carousel/css/carousel.theme.css">

    

    
    <?php wp_head(); ?>
</head>

<body <?php if ( is_home() ) : ?>id="top" class="top"<?php else : ?>id="<?php echo esc_attr( $post->post_name ); ?>" class="inner"<?php endif; ?>>
    <header>
        <div id="header_box" class="flex">
            <h1 id="logo">
                <a href="<?php echo home_url( '/' ); ?>"><svg id="svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 12.724">
       <g>
       <path d="M1.847.376v4.986h-1.751v-4.986h1.751zm-.324.318h-1.108v1.968h1.108v-1.968zm0 2.279h-1.108v2.076h1.108v-2.076zm2.642-.292l-.077-.35.63.019c.191.006.28-.058.357-.21.134-.274.14-1.107.146-1.56h-1.35c-.141 1.146-.471 1.745-1.579 2.254l-.185-.312c1.044-.445 1.286-.878 1.426-1.942h-1.31v-.3h3.324c.006.949-.051 1.688-.147 1.942-.115.318-.331.458-.643.458l-.592.001zm1.305 3.158h-3.081v-2.706h3.081v2.706zm-.343-2.413h-2.401v2.114h2.401v-2.114zM8.876 3.954c-.388-.408-.618-.739-.878-1.21v3.209h-.338v-3.126c-.433.987-.923 1.541-1.14 1.789l-.204-.363c.739-.739 1.159-1.77 1.312-2.152h-1.235v-.318h1.267v-1.102c-.516.07-.783.089-1.197.102l-.07-.318c.325 0 1.363 0 2.426-.37l.134.287c-.274.095-.49.159-.955.248v1.153h1.108v.318h-1.109v.089c.102.191.465.879 1.083 1.433l-.204.331zm3.095 1.834h-2.586v-5.317h2.585l.001 5.317zm-.344-5.011h-1.898v4.693h1.898v-4.693zM15.553.121h.388v1.643h2.783v.344h-2.694c.401 1.834 1.331 2.789 2.757 3.477l-.248.312c-.815-.408-2.216-1.273-2.719-3.317-.375 1.675-1.267 2.623-2.801 3.349l-.191-.325c1.306-.554 2.433-1.528 2.706-3.496h-2.655v-.344h2.674v-1.643zM24.166 2.503c-.529.452-.943.707-1.624 1.057v.229h2.674v.325h-2.674v1.407c0 .433-.255.433-.522.433h-1.063l-.083-.382 1.063.013c.211 0 .255-.007.255-.191v-1.28h-2.789v-.325h2.789v-.554h.28c.331-.153.79-.42 1.146-.726h-3.222v-.312h3.77v.306zm.904-1.287v1.324h-.37v-1.025h-4.776v1.025h-.363v-1.324h4.044c.185-.255.433-.745.56-1.051l.344.14c-.083.178-.312.624-.51.911h1.071zm-4.482-.089c-.128-.274-.306-.573-.484-.809l.293-.134c.255.318.452.707.51.821l-.319.122zm1.681-.102c-.121-.242-.331-.605-.484-.827l.318-.128c.146.198.255.376.484.821l-.318.134zM25.909 5.559c.554-.605 1.127-1.541 1.42-2.26l.293.255c-.108.229-.7 1.446-1.477 2.298l-.236-.293zm1.057-2.783c-.293-.318-1.031-.733-1.05-.745l.185-.287c.236.121.688.382 1.095.72l-.23.312zm.465-1.604c-.274-.268-.853-.624-1.121-.758l.191-.274c.338.134.93.541 1.14.72l-.21.312zm4.139-.274h-1.726v4.336h1.878v.331h-4.342v-.331h2.095v-4.336h-1.573v-.331h3.668v.331zM38.324 1.05h-2.745v.516h2.312v2.305h-2.006c.573.707 1.605 1.318 2.451 1.636l-.14.325c-1.745-.733-2.388-1.554-2.617-1.853v1.968h-.35v-1.961c-.637.809-1.643 1.433-2.598 1.821l-.178-.337c1.204-.433 2.127-1.146 2.452-1.598h-1.942v-2.305h2.267v-.516h-2.744v-.318h2.744v-.611h.35v.611h2.745l-.001.317zm-5.03.828v.688h1.935v-.688h-1.935zm0 .981v.707h1.935v-.707h-1.935zm4.247-.981h-1.961v.688h1.961v-.688zm0 .981h-1.961v.707h1.961v-.707zM44.894 3.184h-5.814v-.306h5.814v.306zm-.592 1.566h-.809c-.063.235-.134.465-.217.707h1.618v.312h-5.814v-.312h1.63c-.057-.204-.108-.395-.216-.707h-.809v-1.159h4.617v1.159zm-3.228-4.215v-.414h.331v.414h1.152v-.414h.326v.414h1.572v1.904h-4.915v-1.904h1.534zm0 .267h-1.204v.541h1.204v-.541zm0 .796h-1.204v.579h1.204v-.579zm2.878 2.299h-3.928v.56h3.928v-.56zm-1.012 1.56c.083-.242.134-.427.197-.707h-2.273l.204.707h1.872zm-.383-4.655h-1.164v.541h1.164v-.541zm0 .796h-1.164v.579h1.164v-.579zm1.567-.796h-1.241v.541h1.241v-.541zm0 .796h-1.241v.579h1.241v-.579zM46.596 2.802c-.274-.255-.726-.516-.974-.63l.172-.293c.325.153.802.478.987.63l-.185.293zm-.923 2.77c.49-.668.77-1.592.847-1.853l.299.178c-.191.7-.477 1.382-.897 1.974l-.249-.299zm1.223-4.489c-.306-.293-.929-.592-.981-.618l.178-.268c.369.159.644.312.993.592l-.19.294zm.057 2.183c.204-.484.338-1.496.35-1.891l.325.045c-.006.089-.108 1.394-.357 1.955l-.318-.109zm1.318-3.158v2.91c0 1.153-.292 2.311-.91 2.897l-.305-.229c.266-.293.872-.949.872-2.668v-2.91h.343zm.547 3.261c-.031-.63-.242-1.56-.369-1.923l.312-.064c.211.637.35 1.395.395 1.898l-.338.089zm.879-3.114v5.438h-.338v-5.438h.338zm.643 3.164c-.051-.535-.261-1.407-.471-1.961l.312-.082c.178.433.432 1.446.497 1.942l-.338.101zm.886-3.311v5.839h-.344v-5.839h.344zM55.266.72v-.605h.357v.605h2.388v.318h-4.426v1.764c0 1.108-.292 2.375-1.05 3.146l-.249-.261c.178-.198.79-.86.93-2.267-.382.261-.56.363-1.026.598l-.089-.363c.484-.216.873-.426 1.133-.579v-2.356h2.032zm-2.662 1.719c-.108-.376-.266-.726-.452-1.108l.261-.134c.191.325.414.834.49 1.089l-.299.153zm5.196.356v2.675c0 .458-.261.484-.535.484h-.554l-.069-.344.572.012c.211.007.249-.064.249-.229v-2.298h-1.433c.134.515.497 1.044 1.338 1.553l-.172.293c-.503-.318-1.064-.732-1.382-1.579-.185.58-.446 1.102-1.178 1.579l-.178-.318c.796-.465.993-1.063 1.096-1.528h-1.185v2.859h-.349v-3.159h1.592c.045-.344.051-.585.051-.789h-1.847v-.312h4.197v.312h-2.005c-.007.261-.013.484-.064.789h1.856zM60.629.325v.312c-.16.503-.35.936-.681 1.566.408.44.655 1.006.655 1.598 0 .331-.069.777-.655.777h-.408l-.095-.357h.471c.166 0 .35-.012.35-.452 0-.783-.446-1.324-.65-1.566.306-.528.478-.955.669-1.56h-1v5.311h-.343v-5.629h1.687zm2.585 2.98v2.063c0 .185.006.21.211.21h.432c.217 0 .274-.012.312-.095.083-.165.115-.592.128-.802l.337.121c-.095.968-.197 1.095-.605 1.095h-.815c-.191 0-.35-.045-.35-.465v-2.127h-.714c.007 1.503-.56 2.228-1.693 2.591l-.152-.318c1.158-.395 1.503-1.025 1.496-2.273h-1.127v-.325h3.935v.325h-1.395zm-.407-3.19v.675h1.643v1.21h-.35v-.897h-2.967v.897h-.357v-1.21h1.675v-.675h.356zm-1.408 2.088v-.312h2.458v.312h-2.458zM.501 11.095c.233.198.511.299.833.301.381-.005.573-.146.579-.421.003-.226-.124-.361-.382-.407l-.388-.055c-.252-.043-.443-.139-.574-.289-.135-.153-.203-.34-.203-.56 0-.264.085-.478.255-.64.164-.16.398-.242.7-.245.364.008.68.113.949.312l-.247.377c-.22-.15-.461-.228-.725-.233-.137 0-.251.035-.342.106-.095.073-.144.183-.147.328 0 .087.033.166.099.237.065.072.171.122.315.149l.33.048c.274.039.477.141.609.305.13.162.195.35.195.564-.015.579-.358.872-1.028.88-.433 0-.806-.137-1.118-.413l.29-.344zM3.09 8.804h.419v1.099h.008c.138-.17.318-.255.542-.255.173 0 .331.063.474.189.142.127.216.314.223.56v1.431h-.419v-1.283c0-.151-.039-.266-.116-.345-.077-.08-.175-.12-.296-.12s-.22.04-.298.12c-.079.079-.118.194-.118.345v1.283h-.419v-3.024zM5.493 10.75c0-.227.018-.402.054-.524.037-.119.095-.219.173-.301.058-.072.138-.135.241-.192.102-.053.232-.082.392-.085.164.003.298.031.4.085.1.057.178.121.233.193.083.081.142.182.176.301.033.122.05.296.05.523s-.017.4-.05.518c-.035.119-.094.222-.177.309l-.099.093-.134.089c-.102.06-.235.091-.4.093-.159-.003-.29-.034-.391-.093-.103-.054-.184-.115-.241-.183-.078-.087-.135-.19-.173-.309-.036-.118-.054-.291-.054-.517zm1.301.004l-.02-.337-.083-.179-.137-.115-.201-.044-.198.044-.141.115-.079.179-.024.333.024.329.079.187.141.11.198.046.201-.046.137-.11.083-.187.02-.325zM9.169 10.32h-.008l-.436 1.508h-.37l-.667-2.153h.444l.4 1.51h.008l.474-1.51h.303l.474 1.51h.009l.398-1.51h.444l-.665 2.153h-.372l-.436-1.508zM12.37 11.637h-.008c-.039.073-.099.127-.181.162-.08.036-.191.054-.333.054-.233-.003-.413-.066-.538-.191-.133-.122-.199-.277-.199-.467 0-.181.058-.331.173-.45.115-.121.284-.184.506-.187h.58v-.227c.003-.19-.139-.283-.428-.277l-.247.033c-.063.026-.113.071-.149.133l-.329-.259c.159-.215.394-.319.704-.314.262-.003.472.048.628.153.157.108.236.293.239.556v1.47h-.418v-.189zm0-.721h-.503c-.244.005-.365.092-.362.259 0 .073.031.136.094.187.06.057.16.085.3.085.176.003.3-.019.372-.064.066-.046.099-.149.099-.311v-.156zM14.655 8.804h.444v1.951c.003.206.06.363.173.471.11.114.251.17.425.17s.316-.057.428-.17c.11-.108.166-.265.169-.471v-1.951h.444v1.999c-.006.318-.105.57-.3.757-.195.192-.443.29-.741.292-.293-.003-.539-.1-.735-.292-.201-.187-.303-.439-.306-.756v-2h-.001zM17.579 9.675h.419v.228h.008c.138-.17.318-.255.542-.255.173 0 .331.063.474.189.142.127.216.314.223.56v1.431h-.419v-1.283c0-.151-.039-.266-.116-.345-.077-.08-.175-.12-.296-.12s-.22.04-.298.12c-.079.079-.118.194-.118.345v1.283h-.419v-2.153zM20.086 8.804h.419v.431h-.419v-.431zm0 .871h.419v2.153h-.419v-2.153zM21.092 9.675h.444l.489 1.509h.008l.487-1.509h.446l-.765 2.153h-.345l-.764-2.153zM23.817 10.916c0 .173.048.304.145.394.09.091.207.137.354.137.17 0 .322-.069.456-.209l.303.268c-.213.235-.463.351-.751.348-.11 0-.217-.017-.321-.05l-.152-.073-.147-.097c-.088-.08-.16-.192-.215-.336-.061-.138-.091-.318-.091-.539 0-.213.026-.39.078-.531.052-.144.119-.257.201-.34.083-.085.176-.145.279-.183.102-.037.202-.056.301-.056.238.003.44.083.605.243.167.162.252.385.255.668v.357h-1.3v-.001zm.881-.357c-.005-.168-.049-.295-.131-.381-.08-.082-.184-.123-.31-.123s-.23.041-.31.123c-.079.086-.123.213-.131.381h.882zM25.853 9.675h.419v.228h.008c.138-.17.319-.255.543-.255.167.003.314.058.438.165l-.306.374c-.088-.072-.18-.108-.275-.108-.107 0-.199.036-.275.108-.086.071-.13.185-.133.343v1.298h-.419v-2.153zM27.866 11.171c.17.184.39.276.661.276.121 0 .219-.024.296-.073.077-.048.115-.116.115-.203 0-.077-.023-.131-.068-.162l-.187-.052-.37-.033c-.176-.017-.319-.077-.429-.183-.113-.102-.17-.245-.173-.429.003-.221.079-.387.227-.498.145-.11.329-.166.551-.166l.259.019.215.058c.129.054.244.127.346.218l-.26.313-.256-.148c-.089-.035-.191-.052-.306-.052-.132 0-.223.024-.276.073-.055.048-.082.11-.082.187l.062.127c.04.04.111.065.213.077l.346.027c.217.017.374.085.471.203.09.117.135.264.135.442-.003.209-.085.371-.247.484-.161.116-.367.176-.617.178-.34 0-.647-.129-.918-.386l.292-.297zM30.078 8.804h.419v.431h-.419v-.431zm0 .871h.419v2.153h-.419v-2.153zM31.361 9.02h.419v.655h.305v.332h-.305v1.255c-.003.109.047.163.148.16h.157v.406h-.219c-.147 0-.268-.047-.361-.141-.096-.09-.145-.219-.145-.389v-1.29h-.21v-.332h.21v-.656h.001zM32.584 9.675h.444l.494 1.508h.008l.492-1.508h.446l-.897 2.599c-.058.162-.137.274-.239.336-.103.06-.219.089-.349.089h-.138v-.406h.122l.152-.046.099-.141.114-.362-.748-2.069zM36.08 8.804h.444v1.557h.009l1.205-1.557h.527l-.938 1.192 1.037 1.831h-.527l-.798-1.479-.514.558v.921h-.445v-3.023zM38.821 10.75c0-.227.018-.402.054-.524.037-.119.095-.219.173-.301.058-.072.138-.135.241-.192.102-.053.232-.082.392-.085.164.003.298.031.4.085.1.057.178.121.233.193.083.081.142.182.176.301.033.122.05.296.05.523s-.017.4-.05.518c-.035.119-.094.222-.177.309l-.099.093-.134.089c-.102.06-.235.091-.4.093-.159-.003-.29-.034-.391-.093-.103-.054-.184-.115-.241-.183-.078-.087-.135-.19-.173-.309-.036-.118-.054-.291-.054-.517zm1.3.004l-.02-.337-.083-.179-.137-.115-.201-.044-.198.044-.141.115-.079.179-.024.333.024.329.079.187.141.11.198.046.201-.046.137-.11.083-.187.02-.325zM41.308 9.02h.419v.655h.305v.332h-.305v1.255c-.004.109.046.163.147.16h.158v.406h-.219c-.147 0-.268-.047-.361-.141-.096-.09-.145-.219-.145-.389v-1.29h-.21v-.332h.21v-.656h.001zM42.601 10.75c0-.227.019-.402.054-.524.038-.119.095-.219.173-.301.058-.072.138-.135.242-.192.102-.053.232-.082.391-.085.165.003.299.031.4.085.101.057.178.121.233.193.082.081.141.182.176.301.033.122.05.296.05.523s-.017.4-.051.518c-.034.119-.093.222-.176.309l-.099.093-.135.089c-.102.06-.234.091-.399.093-.16-.003-.289-.034-.392-.093-.103-.054-.184-.115-.241-.183-.078-.087-.135-.19-.173-.309-.035-.118-.053-.291-.053-.517zm1.3.004l-.02-.337-.083-.179-.137-.115-.201-.044-.197.044-.141.115-.079.179-.024.333.024.329.079.187.141.11.197.046.201-.046.137-.11.083-.187.02-.325zM46.636 9.211h-.803v-.406h2.049v.406h-.802v2.617h-.444v-2.617zM48.129 10.75c0-.227.019-.402.054-.524.038-.119.095-.219.173-.301.058-.072.138-.135.242-.192.102-.053.232-.082.391-.085.165.003.299.031.4.085.101.057.178.121.233.193.082.081.141.182.176.301.033.122.05.296.05.523s-.017.4-.051.518c-.034.119-.093.222-.176.309l-.099.093-.135.089c-.102.06-.234.091-.399.093-.16-.003-.289-.034-.392-.093-.103-.054-.184-.115-.241-.183-.078-.087-.135-.19-.173-.309-.035-.118-.053-.291-.053-.517zm1.3.004l-.02-.337-.083-.179-.137-.115-.201-.044-.197.044-.141.115-.079.179-.024.333.024.329.079.187.141.11.197.046.201-.046.137-.11.083-.187.02-.325zM50.293 9.675h.444l.494 1.508h.008l.492-1.508h.446l-.897 2.599c-.058.162-.138.274-.24.336-.103.06-.219.089-.349.089h-.138v-.406h.122l.152-.046.099-.141.114-.362-.747-2.069zM52.618 10.75c0-.227.019-.402.054-.524.038-.119.095-.219.173-.301.058-.072.138-.135.242-.192.102-.053.232-.082.391-.085.165.003.299.031.4.085.101.057.178.121.233.193.082.081.141.182.176.301.033.122.05.296.05.523s-.017.4-.051.518c-.034.119-.093.222-.176.309l-.099.093-.135.089c-.102.06-.234.091-.399.093-.16-.003-.289-.034-.392-.093-.103-.054-.184-.115-.241-.183-.078-.087-.135-.19-.173-.309-.035-.118-.053-.291-.053-.517zm1.3.004l-.02-.337-.083-.179-.137-.115-.201-.044-.197.044-.141.115-.079.179-.024.333.024.329.079.187.141.11.197.046.201-.046.137-.11.083-.187.02-.325zM55.162 11.171c.17.184.391.276.661.276.12 0 .22-.024.296-.073.077-.048.115-.116.115-.203 0-.077-.023-.131-.068-.162l-.187-.052-.37-.033c-.176-.017-.319-.077-.429-.183-.113-.102-.17-.245-.173-.429.003-.221.079-.387.227-.498.145-.11.329-.166.551-.166l.26.019.215.058c.129.054.244.127.345.218l-.259.313-.256-.148c-.088-.035-.19-.052-.306-.052-.131 0-.223.024-.276.073-.055.048-.082.11-.082.187l.062.127c.04.04.111.065.214.077l.346.027c.217.017.374.085.471.203.089.117.135.264.135.442-.003.209-.085.371-.248.484-.161.116-.366.176-.616.178-.341 0-.647-.129-.919-.386l.291-.297zM57.347 9.675h.419v1.283c0 .146.039.259.118.341.078.082.177.122.298.122s.219-.04.296-.122c.078-.081.116-.195.116-.341v-1.283h.419v2.153h-.419v-.23h-.008c-.137.17-.317.255-.539.255-.173-.003-.329-.067-.468-.194-.151-.124-.228-.308-.231-.551v-1.433h-.001zM62.544 10.507h-1.161v1.321h-.444v-3.024h.444v1.296h1.161v-1.296h.444v3.024h-.444v-1.321zM63.785 10.75c0-.227.019-.402.054-.524.038-.119.095-.219.173-.301.058-.072.138-.135.242-.192.102-.053.232-.082.391-.085.165.003.299.031.4.085.101.057.178.121.233.193.082.081.141.182.176.301.033.122.05.296.05.523s-.017.4-.051.518c-.034.119-.093.222-.176.309l-.099.093-.135.089c-.102.06-.234.091-.399.093-.16-.003-.289-.034-.392-.093-.103-.054-.184-.115-.241-.183-.078-.087-.135-.19-.173-.309-.034-.118-.053-.291-.053-.517zm1.301.004l-.02-.337-.083-.179-.137-.115-.201-.044-.197.044-.141.115-.079.179-.024.333.024.329.079.187.141.11.197.046.201-.046.137-.11.083-.187.02-.325zM66.33 11.171c.17.184.391.276.661.276.12 0 .22-.024.296-.073.077-.048.115-.116.115-.203 0-.077-.023-.131-.068-.162l-.187-.052-.37-.033c-.176-.017-.319-.077-.429-.183-.113-.102-.17-.245-.173-.429.003-.221.079-.387.227-.498.145-.11.329-.166.551-.166l.26.019.215.058c.129.054.244.127.345.218l-.259.313-.256-.148c-.088-.035-.19-.052-.306-.052-.131 0-.223.024-.276.073-.055.048-.082.11-.082.187l.062.127c.04.04.111.065.214.077l.346.027c.217.017.374.085.471.203.089.117.135.264.135.442-.003.209-.085.371-.248.484-.161.116-.366.176-.616.178-.341 0-.647-.129-.919-.386l.291-.297zM68.53 9.675h.419v.224c.139-.16.318-.244.538-.251.255.007.442.101.56.282.057.068.096.157.118.268.02.109.03.294.03.556 0 .255-.01.437-.03.548-.022.11-.061.201-.118.272-.058.083-.134.149-.227.199-.092.051-.203.078-.333.081-.108 0-.203-.024-.287-.072-.091-.044-.175-.105-.251-.181v1.1h-.419v-3.026zm.83 1.747c.1 0 .177-.019.235-.058.057-.04.099-.092.122-.154l.054-.216.004-.24-.004-.252-.054-.216c-.024-.065-.065-.117-.122-.154-.058-.035-.136-.052-.235-.052-.093 0-.168.02-.223.06-.058.04-.1.093-.127.158l-.051.212-.011.244.011.229.051.218c.027.065.068.118.127.158.055.042.13.063.223.063zM70.976 8.804h.419v.431h-.419v-.431zm0 .871h.419v2.153h-.419v-2.153zM72.258 9.02h.419v.655h.305v.332h-.305v1.255c-.003.109.047.163.148.16h.157v.406h-.218c-.147 0-.268-.047-.362-.141-.095-.09-.144-.219-.144-.389v-1.29h-.209v-.332h.209v-.656zM74.808 11.637h-.008c-.038.073-.099.127-.18.162-.08.036-.191.054-.333.054-.233-.003-.413-.066-.538-.191-.133-.122-.199-.277-.199-.467 0-.181.058-.331.173-.45.115-.121.283-.184.506-.187h.58v-.227c.003-.19-.14-.283-.427-.277l-.248.033c-.062.026-.112.071-.148.133l-.33-.259c.16-.215.394-.319.705-.314.262-.003.471.048.628.153.156.108.235.293.238.556v1.47h-.419v-.189zm0-.721h-.503c-.244.005-.365.092-.362.259 0 .073.031.136.094.187.06.057.161.085.3.085.176.003.3-.019.372-.064.065-.046.099-.149.099-.311v-.156zM76.052 8.804h.419v2.47c0 .099.052.147.157.147h.145v.406h-.187c-.152 0-.278-.039-.377-.118-.105-.08-.157-.214-.157-.403v-2.502zM79.602 8.804h.418l1.326 2.15h.008v-2.15h.444v3.024h-.42l-1.324-2.15h-.008v2.15h-.444v-3.024zM83.013 10.916c0 .173.048.304.144.394.09.091.208.137.355.137.17 0 .321-.069.456-.209l.303.268c-.213.235-.462.351-.751.348-.11 0-.217-.017-.321-.05l-.152-.073-.146-.097c-.089-.08-.161-.192-.216-.336-.06-.138-.09-.318-.09-.539 0-.213.026-.39.079-.531.052-.144.119-.257.2-.34.083-.085.176-.145.28-.183.102-.037.201-.056.301-.056.238.003.44.083.605.243.167.162.252.385.255.668v.357h-1.302v-.001zm.881-.357c-.005-.168-.049-.295-.131-.381-.081-.082-.184-.123-.31-.123s-.229.041-.31.123c-.079.086-.122.213-.131.381h.882zM85.039 9.675h.419v1.283c0 .146.039.259.118.341.078.082.177.122.298.122s.219-.04.296-.122c.078-.081.116-.195.116-.341v-1.283h.419v2.153h-.419v-.23h-.008c-.137.17-.317.255-.539.255-.173-.003-.329-.067-.468-.194-.151-.124-.228-.308-.231-.551l-.001-1.433zM87.539 9.675h.419v.228h.008c.138-.17.319-.255.543-.255.167.003.313.058.438.165l-.306.374c-.088-.072-.18-.108-.275-.108-.108 0-.199.036-.276.108-.086.071-.131.185-.133.343v1.298h-.419l.001-2.153zM89.341 10.75c0-.227.019-.402.054-.524.038-.119.095-.219.173-.301.058-.072.138-.135.242-.192.102-.053.232-.082.391-.085.165.003.299.031.4.085.101.057.178.121.233.193.082.081.141.182.176.301.033.122.05.296.05.523s-.017.4-.051.518c-.034.119-.093.222-.176.309l-.099.093-.135.089c-.102.06-.234.091-.399.093-.16-.003-.289-.034-.392-.093-.103-.054-.184-.115-.241-.183-.078-.087-.135-.19-.173-.309-.034-.118-.053-.291-.053-.517zm1.301.004l-.02-.337-.083-.179-.137-.115-.201-.044-.197.044-.141.115-.079.179-.024.333.024.329.079.187.141.11.197.046.201-.046.137-.11.083-.187.02-.325zM91.799 8.804h.419v2.47c0 .099.052.147.157.147h.145v.406h-.187c-.152 0-.278-.039-.377-.118-.105-.08-.157-.214-.157-.403v-2.502zM93.056 10.75c0-.227.019-.402.054-.524.038-.119.095-.219.173-.301.058-.072.138-.135.242-.192.102-.053.232-.082.391-.085.165.003.299.031.4.085.101.057.178.121.233.193.082.081.141.182.176.301.033.122.05.296.05.523s-.017.4-.051.518c-.034.119-.093.222-.176.309l-.099.093-.135.089c-.102.06-.234.091-.399.093-.16-.003-.289-.034-.392-.093-.103-.054-.184-.115-.241-.183-.078-.087-.135-.19-.173-.309-.035-.118-.053-.291-.053-.517zm1.3.004l-.02-.337-.083-.179-.137-.115-.201-.044-.197.044-.141.115-.079.179-.024.333.024.329.079.187.141.11.197.046.201-.046.137-.11.083-.187.02-.325zM96.701 11.604c-.138.161-.317.244-.538.249-.135-.003-.247-.033-.337-.089-.093-.054-.165-.112-.215-.174-.055-.071-.094-.157-.118-.26-.026-.101-.038-.293-.038-.577 0-.289.012-.485.038-.587.024-.101.063-.186.118-.256.05-.067.121-.128.215-.181.09-.051.202-.078.337-.08.207 0 .387.085.538.255v-.228h.419v2.101c-.005.324-.095.562-.271.713-.177.156-.388.234-.635.234-.282-.006-.523-.125-.722-.36l.325-.267.186.132c.071.04.144.062.22.064.144 0 .259-.041.345-.123.086-.083.131-.199.133-.346v-.22zm-.827-.85l.016.341.066.162.129.106c.055.039.123.058.205.058l.205-.058.124-.106.071-.162.011-.341-.011-.349-.071-.158-.124-.115-.205-.052-.205.052-.129.115-.066.158-.016.349zM97.72 9.675h.444l.494 1.508h.008l.492-1.508h.446l-.897 2.599c-.058.162-.138.274-.24.336-.103.06-.219.089-.349.089h-.138v-.406h.122l.152-.046.099-.141.114-.362-.747-2.069zM69.666 5.476c0 .376-.192.567-.58.567h-.529l-.128-.77h.427c.14 0 .159-.032.159-.191v-1.057h-.515c-.077 1.185-.293 1.668-.465 2.018l-.541-.675c.159-.375.363-.866.363-2.165v-2.993h1.808l.001 5.266zm-.65-4.553h-.483v.84h.483v-.84zm0 1.516h-.483v.897h.483v-.897zm1.338-.637c-.172-.624-.465-1.153-.548-1.299l.688-.223c.261.478.389.809.541 1.318l-.681.204zm.77.439c.203.185.331.312.554.592.128-.369.191-.72.217-.866l.643.235c-.045.223-.14.7-.382 1.286.286.452.394.656.515.898l-.509.49c-.128-.261-.198-.408-.35-.675-.274.471-.432.636-.605.815l-.516-.484v.656h2.013v-2.891h.72v3.611h-3.439v-3.611h.706v.357l.433-.413zm-.433 2.261c.185-.185.389-.382.695-.962-.134-.185-.332-.465-.695-.853v1.815zm.751-2.974c-.012-.159-.057-.808-.318-1.369l.738-.128c.172.433.274 1.019.312 1.395l-.732.102zm.872.115c.3-.573.44-.911.637-1.509l.72.28c-.223.605-.357.917-.687 1.522l-.67-.293zM76.327 4.107c-.255-.248-.338-.35-.535-.579v2.503h-.764v-2.261c-.197.172-.343.293-.662.503l-.281-.853c.618-.401 1.21-.917 1.585-1.706h-1.477v-.752h.834v-.936h.764v.936h.663v.751c-.128.375-.255.63-.51 1.012.293.325.695.611.713.63v-2.388h1.312v-.943h.732v.943h1.318v3.706h-1.318v1.357h-.731v-1.344h-1.312v-1.28l-.331.701zm1.643-2.419h-.586v.77h.586v-.77zm0 1.445h-.586v.815h.586v-.815zm1.318-1.445h-.586v.77h.586v-.77zm0 1.445h-.586v.815h.586v-.815zM80.747 2.77l.465-.012.331-.433c-.394-.484-.7-.7-.834-.79l.363-.688.185.147c.274-.458.42-.815.49-.974l.675.198c-.211.414-.509.948-.688 1.203l.248.274c.325-.497.472-.751.605-.993l.644.293c-.427.726-1.058 1.535-1.223 1.732l.572-.025-.114-.382.515-.178c.134.35.268.777.338 1.242l-.567.172-.032-.235-.292.038v2.687h-.669v-2.623l-.943.076-.069-.729zm.834 1.057c-.006.128-.057 1.248-.235 1.847l-.618-.293c.071-.223.198-.623.249-1.636l.604.082zm1.509 1.305l-.35.051c0-.401-.051-.974-.14-1.376l.528-.127c.166.681.178 1.286.178 1.407h1.255v-.733h-1.14v-.731h1.14v-.554h.783v.554h1.229v.732h-1.229v.733h1.465v.738h-3.719v-.694zm1.057-4.183h-.847v-.707h3.235v.707c-.089.191-.255.56-.93 1.165.268.121.592.255 1.324.414l-.28.751c-.44-.115-1.044-.299-1.7-.669-.65.414-1.153.573-1.421.656l-.375-.675c.229-.057.605-.159 1.152-.445-.4-.37-.611-.707-.757-.943l.599-.254zm.057 0c.166.235.389.522.738.79.466-.357.593-.56.746-.79h-1.484zM88.469 3.865v2.165h-.795v-5.126h2.305v-.873h.808v.873h2.286v4.553c0 .166-.051.573-.567.573h-1.164l-.134-.809h.904c.095 0 .165-.026.165-.153v-1.197l-.439.624c-.77-.567-1.178-1.115-1.452-1.885-.326.923-1.026 1.585-1.484 1.878l-.433-.623zm0-2.197v2.095c.746-.471 1.273-1.229 1.446-2.095h-1.446zm3.808 0h-1.452c.077.478.28 1.312 1.452 2.108v-2.108zM94.956.987c-.528.032-.732.038-.935.038l-.121-.713c.535 0 1.624-.07 2.35-.299l.3.738c-.198.058-.338.095-.841.165v.783h.732v.732h-.732v.051c.286.471.58.757.821.98l-.42.707c-.229-.305-.312-.439-.401-.624v2.49h-.752v-2.458c-.363.72-.662 1.114-.866 1.382l-.299-.968c.446-.382.809-.949 1.089-1.56h-.943v-.732h1.018v-.712zm3.649 2.579v-3.527h.809v3.362l.509-.108.077.79-.586.121v1.834h-.809v-1.668l-2.082.426-.095-.783 2.177-.447zm-1.553-1.694c.515.299.802.528 1.146.897l-.541.592c-.312-.375-.745-.707-1.095-.923l.49-.566zm.305-1.604c.446.223.847.548 1.153.91l-.535.605c-.388-.44-.566-.611-1.083-.955l.465-.56z"/>
      </g>
      </svg></a>
            </h1>

            <nav class="pc">
                <ul class="flex">
                    <li><a href="<?php echo home_url( '/' ); ?>">HOME</a></li>
                    <li><a href="<?php echo home_url( '/' ); ?>message/index.html">MESSAGE</a></li>
                    <li><a href="<?php echo home_url( '/' ); ?>member/index.html">MEMBER</a></li>
                    <li><a href="<?php echo home_url( '/' ); ?>work/index.html">WORK</a></li>
                    <li><a href="<?php echo home_url( '/' ); ?>blog">BLOG</a></li>
                    <li><a href="<?php echo home_url( '/' ); ?>schedule_list">SCHEDULE</a></li>
                    <li><a href="<?php echo home_url( '/' ); ?>recruit/index.html">RECRUIT</a></li>
                    <li><a href="<?php echo home_url( '/' ); ?>contact/">CONTACT</a></li>
                </ul>
                <div class="drbtn sp"> <span class="hambarg"></span> <span class="hambarg"></span> <span class="hambarg"></span> <span>MENU</span> </div>
            </nav>



            <div class="zdo_drawer_menu sp">
                <!--<div class="zdo_drawer_bg"></div>-->

                <button type="button" class="zdo_drawer_button"> <span class="zdo_drawer_bar zdo_drawer_bar1"></span> <span class="zdo_drawer_bar zdo_drawer_bar2"></span> <span class="zdo_drawer_bar zdo_drawer_bar3"></span> <span class="zdo_drawer_menu_text zdo_drawer_text">MENU</span> <span class="zdo_drawer_close zdo_drawer_text">CLOSE</span> </button>
                <nav class="zdo_drawer_nav_wrapper">
                    <ul class="zdo_drawer_nav">
                        <li><a href="<?php echo home_url( '/' ); ?>">HOME</a></li>
                        <li><a href="<?php echo home_url( '/' ); ?>message/index.html">ご挨拶</a></li>
                        <li><a href="<?php echo home_url( '/' ); ?>member/index.html">診療医メンバー</a></li>
                        <li><a href="<?php echo home_url( '/' ); ?>work/index.html">我々の仕事</a></li>
                        <li class="accordionbox">
                            <dl class="accordionlist">
                                <dt class="flex">
           
         <p class="clearfix" >ブログ</p>
           <p class="accordion_icon"><span></span><span></span></p>
          </dt>
                                <dd>
                                    <ul class="category">
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/staff">スタッフより</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/activity">学会の活動</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/kamiyadc">管理者より</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/illness">病気のこと</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/dayreport">入局・研修について</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog">ブログ一覧</a></li>
                                    </ul>
                                </dd>
                            </dl>
                        </li>
                        <li><a href="<?php echo home_url( '/' ); ?>schedule_list">今後のスケジュール</a></li>
                        <li><a href="<?php echo home_url( '/' ); ?>recruit/index.html">採用情報</a></li>
                        <li><a href="<?php echo home_url( '/' ); ?>contact/">お問い合わせ</a></li>
                        <li><a href="http://www.showa-u.ac.jp/SHKT/" target="_blank">病院からのお知らせ</a></li>
                        <li><a href="<?php echo home_url( '/' ); ?>outline/index.html">病院概要</a></li>
                        <li><a href="http://www.showa-u.ac.jp/SHKT/privacy/" target="_blank">個人情報保護方針</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <!--header-->