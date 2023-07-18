set datafile separator ","
set key autotitle columnheader
set terminal svg size 800,800 enhanced font 'Helvetica,10'
set output 'out.svg'

infile = 'processed.csv'

set title 'USW00023183 - Phoenix Airport'
set xlabel 'Year'
set ylabel 'Days'

set fit logfile '/dev/null'

set multiplot layout 2, 1

f(x) = m*x + b
g(x) = n*x + c
fit f(x) infile using 1:2 via m,b
fit g(x) infile using 1:4 via n,c

plot infile using 1:2 with lines, \
infile using 1:4 with lines, \
f(x) notitle, \
g(x) notitle

f(x) = m*x + b
g(x) = n*x + c
fit f(x) infile using 1:3 via m,b
fit g(x) infile using 1:5 via n,c

plot infile using 1:3 with lines, \
infile using 1:5 with lines, \
f(x) notitle, \
g(x) notitle
