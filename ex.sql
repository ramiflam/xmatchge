USE [DrorBreeding]
GO
/****** Object:  Table [dbo].[tblTeken]    Script Date: 02/23/2015 02:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tblTeken](
	[RecordType] [int] NULL,
	[TEKEN_AGAN] [smallint] NULL,
	[TEKEN_AGAN2] [smallint] NULL,
	[TEKEN_MILK] [smallint] NULL,
	[TEKEN_FAT] [float] NULL,
	[TEKEN_FATP] [float] NULL,
	[TEKEN_PRT] [float] NULL,
	[TEKEN_PRTP] [float] NULL,
	[TEKEN_SCC] [float] NULL,
	[SHIPUT_LOW_SENS] [smallint] NULL,
	[SHIPUT_MID_SENS] [smallint] NULL,
	[SHIPUT_HIGH_SENS] [smallint] NULL,
	[LOW_SENS] [float] NULL,
	[MID_SENS] [float] NULL,
	[HIGH_SENS] [float] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tblParameters]    Script Date: 02/23/2015 02:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tblParameters](
	[FarmNumber] [nvarchar](10) NULL,
	[FarmName] [nvarchar](30) NULL,
	[MagicNumber] [smallint] NULL,
	[BullsUsageYoungBulls] [smallint] NULL,
	[BullsUsageMeatBulls] [smallint] NULL,
	[BullsUsageCrossBreedingBulls] [smallint] NULL,
	[MeatBullsLactationNumber] [smallint] NULL,
	[MatchProductionKGMilk] [bit] NOT NULL,
	[MatchProductionFatPercentage] [bit] NOT NULL,
	[MatchProductionProteinPercentage] [bit] NOT NULL,
	[MatchProductionSCC] [bit] NOT NULL,
	[MatchProductionFertility] [bit] NOT NULL,
	[MatchJudgmentGeneralSize] [bit] NOT NULL,
	[MatchJudgmentGeneralUdder] [bit] NOT NULL,
	[MatchJudgmentNippleLocation] [bit] NOT NULL,
	[MatchJudgmentUdderDepth] [bit] NOT NULL,
	[MatchJudgmentGeneralLegs] [bit] NOT NULL,
	[MatchJudgmentPelvisStructure] [bit] NOT NULL,
	[MatchJudgmentOverallGrade] [bit] NOT NULL,
	[BullsInseminationYoungBulls] [smallint] NULL,
	[BullsInseminationMeatBulls] [smallint] NULL,
	[BullsInseminationOtherBulls] [smallint] NULL,
	[GeneticDate] [datetime] NULL,
	[BullsInseminationTotal] [smallint] NULL,
	[BullsFirstInseminationDate] [datetime] NULL,
	[BullsLastInseminationDate] [datetime] NULL,
	[RestingDaysHeifers] [smallint] NULL,
	[RestingDaysPrimipara] [smallint] NULL,
	[RestingDaysCows] [smallint] NULL,
	[HerdDifference] [smallint] NULL,
	[HeredityEvaluation] [smallint] NULL,
	[LastInseminationsUpdate] [datetime] NULL,
	[InseminationsUpdateMethod] [tinyint] NULL,
	[LastUpdateDaysWarning] [tinyint] NULL,
	[ActivationSnooze] [int] NULL,
	[LastTimeActivated] [datetime] NULL,
	[LastUpgradeDate] [datetime] NULL,
	[SelectedCowsForMatching] [nvarchar](max) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tblGeneticCows]    Script Date: 02/23/2015 02:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tblGeneticCows](
	[SE] [int] NULL,
	[BurnNumber] [int] NULL,
	[LactationNumber] [tinyint] NULL,
	[BirthDate] [nvarchar](10) NULL,
	[Father] [int] NULL,
	[FatherName] [nvarchar](12) NULL,
	[Mother] [int] NULL,
	[FatherMother] [int] NULL,
	[FatherMotherName] [nvarchar](12) NULL,
	[FatherFather] [int] NULL,
	[FatherFatherName] [nvarchar](12) NULL,
	[p_hmm] [smallint] NULL,
	[p_milk] [smallint] NULL,
	[p_fat] [float] NULL,
	[p_pfat] [float] NULL,
	[p_prot] [float] NULL,
	[p_pprot] [float] NULL,
	[p_scc] [float] NULL,
	[b_hmm] [smallint] NULL,
	[m_milk] [smallint] NULL,
	[b_fat] [float] NULL,
	[b_pfat] [float] NULL,
	[b_prot] [float] NULL,
	[b_pprot] [float] NULL,
	[b_scc] [float] NULL,
	[size] [smallint] NULL,
	[type] [smallint] NULL,
	[udder] [smallint] NULL,
	[legs] [smallint] NULL,
	[total] [smallint] NULL,
	[hight] [smallint] NULL,
	[b_cap] [smallint] NULL,
	[rump_a] [smallint] NULL,
	[rump_w] [smallint] NULL,
	[r_legs] [smallint] NULL,
	[clow] [smallint] NULL,
	[f_udder] [smallint] NULL,
	[teat_p] [smallint] NULL,
	[t_length] [smallint] NULL,
	[udder_d] [smallint] NULL,
	[r_udder] [smallint] NULL,
	[legament] [smallint] NULL,
	[p_frt] [float] NULL,
	[b_frt] [float] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tblCows]    Script Date: 02/23/2015 02:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tblCows](
	[SE] [int] NULL,
	[BurnNumber] [int] NULL,
	[LactationNumber] [tinyint] NULL,
	[Father] [int] NULL,
	[FatherFather] [int] NULL,
	[FatherMother] [int] NULL,
	[KGHMM] [smallint] NULL,
	[KGMILK] [smallint] NULL,
	[Fertility] [float] NULL,
	[FatPercentage] [float] NULL,
	[KGProtein] [float] NULL,
	[ProteinPercentage] [float] NULL,
	[SCC] [float] NULL,
	[GeneralSize] [smallint] NULL,
	[GeneralUdder] [smallint] NULL,
	[NippleLocation] [smallint] NULL,
	[UdderDepth] [smallint] NULL,
	[GeneralLegs] [smallint] NULL,
	[OverallGrade] [smallint] NULL,
	[PelvisStructure] [smallint] NULL,
	[MatchStatus] [tinyint] NULL,
	[ForcedBull] [nvarchar](12) NULL,
	[InseminationDate] [nvarchar](10) NULL,
	[HMMRankForMatchedCows] [smallint] NULL,
	[CowManRank] [nvarchar](255) NULL,
	[CVM] [tinyint] NULL,
	[HMMRankAll] [smallint] NULL,
	[InseminatingBull] [int] NULL,
	[StopInseminations] [bit] NOT NULL,
	[ExpectedCalvingDate] [nvarchar](10) NULL,
	[BirthDate] [nvarchar](10) NULL,
	[Group_] [nvarchar](20) NULL,
	[CalvingDate] [nvarchar](10) NULL,
	[LastInseminationNumber] [smallint] NULL,
	[PregnancyDays] [smallint] NULL,
	[AdjustECM] [smallint] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tblBulls]    Script Date: 02/23/2015 02:15:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tblBulls](
	[SE] [int] NULL,
	[Name] [nvarchar](12) NULL,
	[Father] [int] NULL,
	[FatherFather] [int] NULL,
	[MotherFather] [int] NULL,
	[ActualInseminations] [int] NULL,
	[Hazday] [int] NULL,
	[Repetition] [smallint] NULL,
	[KGHMM] [smallint] NULL,
	[KGMILK] [smallint] NULL,
	[Fertility] [float] NULL,
	[FatPercentage] [float] NULL,
	[KGProtein] [float] NULL,
	[ProteinPercentage] [float] NULL,
	[SCC] [float] NULL,
	[GeneralSize] [smallint] NULL,
	[GeneralUdder] [smallint] NULL,
	[NippleLocation] [smallint] NULL,
	[UdderDepth] [smallint] NULL,
	[GeneralLegs] [smallint] NULL,
	[OverallGrade] [smallint] NULL,
	[PelvisStructure] [smallint] NULL,
	[PlannedUsage] [smallint] NULL,
	[MatchStatus] [tinyint] NULL,
	[HeiferStatus] [tinyint] NULL,
	[CVM] [tinyint] NULL,
	[BullType] [tinyint] NULL,
	[Visible] [bit] NOT NULL,
	[UsageLimit] [bit] NOT NULL,
	[FromInsemination] [smallint] NULL,
	[ToInsemination] [smallint] NULL,
	[UsageOrder] [smallint] NULL,
	[OrderByHMM] [bit] NOT NULL
) ON [PRIMARY]
GO
