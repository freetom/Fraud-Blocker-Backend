# Fraud-Blocker-Backend
Server application for the Fraud Blocker extension. Site also backed up here


```
Copyright 2016,2017 Bortoli Tomas

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
```


## API
`/api/` contains the code used to handle clients requests. 

These roughly are:
* report/contro-report site
* avoid-report/avoid-contro-report site
* download updated from black/gray/white lists

## Reports Management
`/management/` contains the (now simple) system that *report's reviewers* shall use to review and judge reported sites.

## Issues and concerns
At the moment the system defines good, bad and just reported sites. The problem is that these three categories simply don't fit whatever site is in the net. Hence, at least a new category for sites that may be dangerous (because of user controlled content, like freely uploaded/downloaded executables) should be added to improve awareness of users that are surfing the web. The point is that the plug-in should **protect** users and **increase consciousness** about which kind of site he is surfing.

Ideas and help are appreaciated
