<doctype>
<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" type="text/css" href="public_html/css/w3.css" />
    </head>
    <body class="w3-teal" ng-app="app">
        <h1>Setup Instructions</h1>
        <div ng-controller="stepsController">
            <div class="panel">
                <div ng-show="step=='1'">
                    <h2>Step 1</h2>
                </div>
                <div ng-show="step=='2'">
                    <h2>Step 2</h2>
                </div>
                <div ng-show="step=='3'">
                    <h2>Step 3</h2>
                </div>
                <div ng-show="step=='4'">
                    <h2>Step 4</h2>
                </div>
                <div ng-show="step=='5'">
                    <h2>Step 5</h2>
                </div>
            </div>
            <div>
                <a href="#" class="w3-btn w3-indigo w3-round w3-border w3-border-white w3-hover-border-yellow w3-hover-blue" ng-click="step=='1'">Step 1</a>
                <a href="#" class="w3-btn w3-indigo w3-round w3-border w3-border-white w3-hover-border-yellow w3-hover-blue" ng-click="step=='2'">Step 2</a>
                <a href="#" class="w3-btn w3-indigo w3-round w3-border w3-border-white w3-hover-border-yellow w3-hover-blue" ng-click="step=='3'">Step 3</a>
                <a href="#" class="w3-btn w3-indigo w3-round w3-border w3-border-white w3-hover-border-yellow w3-hover-blue" ng-click="step=='4'">Step 4</a>
                <a href="#" class="w3-btn w3-indigo w3-round w3-border w3-border-white w3-hover-border-yellow w3-hover-blue" ng-click="step=='5'">Step 5</a>
            </div>
        </div>
        <script type="text/javascript" src="js/angularjs/1.6.8/angular.min.js"></script>
        <script src="https://unpkg.com/@uirouter/angularjs@1.0.13/release/angular-ui-router.min.js"></script>
        <script type="text/javascript" src="js/install/steps.js"></script>
    </body>
</html>