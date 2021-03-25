<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ParSU ALUMNI</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script> 
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            /* .v-navigation-drawer__content {
              overflow: hidden !important;
              scrollbar-width: none;
              -ms-overflow-style: none;
            }
            
            .v-navigation-drawer::-webkit-scrollbar {
              width: 0;
              height: 0;
            } */
            .light::-webkit-scrollbar {
  width: 15px;
}

.light::-webkit-scrollbar-track {
  background: #e6e6e6;
  border-left: 1px solid #dadada;
}

.light::-webkit-scrollbar-thumb {
  background: #b0b0b0;
  border: solid 3px #e6e6e6;
  border-radius: 7px;
}

.light::-webkit-scrollbar-thumb:hover {
  background: black;
}

.dark::-webkit-scrollbar {
  width: 15px;
}

.dark::-webkit-scrollbar-track {
  background: #202020;
  border-left: 1px solid #2c2c2c;
}

.dark::-webkit-scrollbar-thumb {
  background: #3e3e3e;
  border: solid 3px #202020;
  border-radius: 7px;
}

.dark::-webkit-scrollbar-thumb:hover {
  background: white;
}
            </style>
            <style>
/* When setting CSS, remember that priority increases with specificity, so don't forget to select the exisiting classes as well */

    .Vue-Toastification__toast--success.my-custom-toast-class {
        background-color: #212121;
    }

    /* Applied to the toast body when using regular strings as content */
    .Vue-Toastification__toast-body.custom-class-1 {
        font-size: 14px;
    }

    /* Applied to a wrapper div when using a custom component as content */
    .Vue-Toastification__toast-component-body.custom-class-2 {
        width: 100%;
    }
</style>
    </head>
    <body>
        <div id="app">
            <app/>
        </div>
        <!-- Load Facebook SDK for JavaScript -->
      
    </body>
</html>
