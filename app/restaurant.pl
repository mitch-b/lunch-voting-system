#!/usr/bin/perl

use strict;
use Time::localtime;
#my $tempfile = shift;
#my $outfile = shift;
#my $placefile = shift;
my $tempfile = "template.php";
my $outfile = "index.php";
my $placefile = "weekly.txt";

# code goes here to determine if last friday
my $thisweek = localtime()->mon;
my $nextweek = localtime(time + 86400 * 7)->mon;
$placefile = "monthly.txt" if $thisweek ne $nextweek;
print "using: $placefile\n";
open(TEMP,$tempfile) or die $!;
open(OUT,">$outfile");
open(PLACES,$placefile);

chomp(my @restaurants = <PLACES>);

my $numOfPlaces = $#restaurants;

my $picked = "";

my @picks;
my $x;

for(my $i = 0; $i < 3; $i++)
{
   $x = int(rand($numOfPlaces));
   while($picked =~ /-$x-/)
   {
      $x = int(rand($numOfPlaces));
   }
   $picked .= "-$x-";
   $picks[$i] = $restaurants[$x];
} 

print $picked . "\n";

foreach my $place(@picks)
{
   print $place . "\n";
}

my @template = <TEMP>;
my $tempstring;
foreach my $line(@template)
{
    $tempstring .= $line;
}

$tempstring =~ s/var1/$picks[0]/g;
$tempstring =~ s/var2/$picks[1]/g;
$tempstring =~ s/var3/$picks[2]/g;

print OUT $tempstring;

close TEMP;
close IN;
close OUT;
