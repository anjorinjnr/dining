/**
 * Created by eanjorin on 7/3/14.
 */

define([], function () {

    function link(scope, e, attrs) {
        scope.subjects = [
            {
            },
            {
                'id': 1,
                'title': 'English'
            },
            {
                'id': 6,
                'title': 'Maths'
            },
            {
                'id': 7,
                'title': 'Literature'
            },
            {
                'id': 8,
                'title': 'Biology'
            },
            {
                'id': 9,
                'title': 'German'
            },
            {
                'id': 11,
                'title': 'Biometrics'
            },
            {
                'id': 13,
                'title': 'Algebra'
            },
            {
                'id': 14,
                'title': 'Calculus'
            },
            {
                'id': 15,
                'title': 'Chemistry'
            },
            {
                'id': 16,
                'title': 'Computer'
            },
            {
                'id': 17,
                'title': 'Geometry'
            },
            {
                'id': 18,
                'title': 'Music'
            },
            {
                'id': 19,
                'title': 'Physic'
            },
            {
                'id': 20,
                'title': 'SAT'
            },
            {
                'id': 21,
                'title': 'Writing'
            }
        ];
        if (scope.select !== undefined) {
            for (var i = 1; i < scope.subjects.length; i++) {
                if (scope.subjects[i].id === Number.parseInt(scope.select)) {
                    scope.selectedSubject = scope.subjects[i];
                    break;
                }
            }
        }
        console.log(e);
        scope.$watch('subjects', function () {
            e.trigger('chosen:updated');
        });

        e.chosen({width: '100%'});

        //console.log(element.find('#single-subject'));


    }

    function controller($scope) {


    };
    var SubjectDirective = function () {
        return {
            restrict: 'E',
            replace: true,
            //require: ['^?form', 'ngModel'],
            scope: {
                selectedSubject: '=?',
                selectedSubjects: '=?',
                select: '=select',
                multiple: '=?'
            },
            //controller: controller,
            templateUrl: function (e, a) {
                if ('multiple' in a) {
                    return 'components/subject/subject-directive/subj-multiple.tpl.html';
                }
                return 'components/subject/subject-directive/subj.tpl.html';

            },
            link: link
        };
    };
    return SubjectDirective;
});
