define([/*'angular'*/ './subj-directive'], function(SubjectDirective)
{
   return  angular.module('nt.select-subject', [])
       .directive('selectSubject', SubjectDirective);
           //directive('selectSubjectSingle', SubjectDirective.selecSubjectSingle)
           // directive('selectSubjectSingle', SubjectDirective.selecSubjectSingle);;
});

